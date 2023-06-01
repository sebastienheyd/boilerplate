<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Testing\Fluent\AssertableJson;
use Sebastienheyd\Boilerplate\Tests\factories\UserFactory;
use Sebastienheyd\Boilerplate\Tests\TestCase;

class GptTest extends TestCase
{
    public function testForm()
    {
        UserFactory::create()->admin(true);

        $resource = $this->get(route('boilerplate.gpt.index', [], false));
        $resource->assertSee('first person singular', false);
    }

    public function testProcessNoInput()
    {
        UserFactory::create()->admin(true);

        $response = $this->post(route('boilerplate.gpt.process', [], false), []);
        $response->assertNotFound();
    }

    public function testProcessGeneratorNoInput()
    {
        UserFactory::create()->admin(true);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'tab' => 'generator'
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'tab', 'html'])
                ->where('success', false)
                ->where('tab', 'gpt-generator')
                ->where('html', function ($html) {
                    return strstr($html, 'The Topic field is required.') !== false && strstr($html, 'The Language field is required.') !== false;
                });
        });
    }

    public function testProcessGenerator()
    {
        UserFactory::create()->admin(true);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'tab'      => 'generator',
            'topic'    => 'Test',
            'type'     => 'a text',
            'language' => 'en',
            'actas'    => 'tester',
            'pov'      => 'first person singular',
            'tone'     => 'formal',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'prepend', 'id'])
                ->where('success', true)
                ->where('prepend', true)
                ->where('id', function ($id) {
                    return preg_match('#^gpt-[a-zA-Z0-9]{16}$#', $id) !== false;
                });
        });

        $json = json_decode($response->getContent());
        $cache = Cache::get($json->id);
        $this->assertStringContainsString('Act as "tester". ', $cache);
        $this->assertStringContainsString('Point of view: "first person singular". ', $cache);
        $this->assertStringContainsString('Tone: "formal". ', $cache);
        $this->assertStringContainsString('Write a text in "en" language about "Test"', $cache);
    }

    public function testProcessPromptNoInput()
    {
        UserFactory::create()->admin(true);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'tab' => 'prompt'
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'tab', 'html'])
                ->where('success', false)
                ->where('tab', 'gpt-prompt')
                ->where('html', function ($html) {
                    return strstr($html, 'The Prompt field is required.') !== false;
                });
        });
    }

    public function testProcessPrompt()
    {
        UserFactory::create()->admin(true);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'tab'      => 'prompt',
            'prompt'   => 'This is a test',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'prepend', 'id'])
                ->where('success', true)
                ->where('prepend', true)
                ->where('id', function ($id) {
                    return preg_match('#^gpt-[a-zA-Z0-9]{16}$#', $id) !== false;
                });
        });

        $json = json_decode($response->getContent());
        $cache = Cache::get($json->id);
        $this->assertStringContainsString('This is a test', $cache);
    }

    public function testProcessRewriteNoInput()
    {
        UserFactory::create()->admin(true);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'tab' => 'rewrite'
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'tab', 'html'])
                ->where('success', false)
                ->where('tab', 'gpt-rewrite')
                ->where('html', function ($html) {
                    return strstr($html, 'The Original content field is required.') !== false && strstr($html, 'The Language field is required.') !== false;
                });
        });
    }

    public function testProcessRewrite()
    {
        UserFactory::create()->admin(true);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'type' => 'rewrite',
            'tab' => 'rewrite',
            'original-content' => 'Test',
            'language' => 'en',
            'actas' => 'tester',
            'pov' => 'first person singular',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'prepend', 'id'])
                ->where('success', true)
                ->where('prepend', false)
                ->where('id', function ($id) {
                    return preg_match('#^gpt-[a-zA-Z0-9]{16}$#', $id) !== false;
                });
        });

        $json = json_decode($response->getContent());
        $cache = Cache::get($json->id);
        $this->assertStringContainsString('Act as "tester".', $cache);
        $this->assertStringContainsString('Point of view: first person singular.', $cache);
        $this->assertStringContainsString('Rewrite the following text', $cache);
    }

    public function testProcessTitle()
    {
        UserFactory::create()->admin(true);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'type' => 'title',
            'tab' => 'rewrite',
            'original-content' => 'Test',
            'language' => 'en',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'prepend', 'id'])
                ->where('success', true)
                ->where('prepend', true)
                ->where('id', function ($id) {
                    return preg_match('#^gpt-[a-zA-Z0-9]{16}$#', $id) !== false;
                });
        });

        $json = json_decode($response->getContent());
        $cache = Cache::get($json->id);
        $this->assertStringContainsString('Write a title for the following text', $cache);
    }

    public function testProcessSummarize()
    {
        UserFactory::create()->admin(true);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'type' => 'summary',
            'tab' => 'rewrite',
            'original-content' => 'Test',
            'language' => 'en',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'prepend', 'id'])
                ->where('success', true)
                ->where('prepend', false)
                ->where('id', function ($id) {
                    return preg_match('#^gpt-[a-zA-Z0-9]{16}$#', $id) !== false;
                });
        });

        $json = json_decode($response->getContent());
        $cache = Cache::get($json->id);
        $this->assertStringContainsString('Summarize the following text', $cache);
    }

    public function testProcessTranslate()
    {
        UserFactory::create()->admin(true);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'type' => 'translate',
            'tab' => 'rewrite',
            'original-content' => 'Test',
            'language' => 'en',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'prepend', 'id'])
                ->where('success', true)
                ->where('prepend', false)
                ->where('id', function ($id) {
                    return preg_match('#^gpt-[a-zA-Z0-9]{16}$#', $id) !== false;
                });
        });

        $json = json_decode($response->getContent());
        $cache = Cache::get($json->id);
        $this->assertStringContainsString('Act as a professionnal translator.', $cache);
        $this->assertStringContainsString('Translate the following text', $cache);
    }

    public function testStreamNoCache()
    {
        UserFactory::create()->admin(true);

        $response = $this->get(route('boilerplate.gpt.stream', [], false));
        $response->assertNotFound();
    }

    public function testStreamId()
    {
        UserFactory::create()->admin(true);

        $response = $this->get(route('boilerplate.gpt.stream', ['id' => 'false'], false));
        $response->assertNotFound();
    }

//    public function testStreamCache()
//    {
//        error_reporting(0);
//        UserFactory::create()->admin(true);
//
//        Cache::put('gpt-test', 'Test prompt');
//
//        $response = $this->get(route('boilerplate.gpt.stream', ['id' => 'gpt-test'], false));
//    }

}
