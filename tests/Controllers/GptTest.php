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
            $json->hasAll(['success', 'id'])
                ->where('success', true)
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
            'tab'    => 'prompt',
            'prompt' => 'This is a test',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'id'])
                ->where('success', true)
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
                    return strstr($html, 'The Selected content field is required.') !== false;
                });
        });
    }

    public function testProcessRewrite()
    {
        UserFactory::create()->admin(true);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'tab'              => 'rewrite',
            'original-content' => 'This is a test',
            'type'             => 'rewrite',
            'actas'            => 'test writer',
            'pov'              => 'first person singular',
            'tone'             => 'humorous',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'id'])
                ->where('success', true)
                ->where('id', function ($id) {
                    return preg_match('#^gpt-[a-zA-Z0-9]{16}$#', $id) !== false;
                });
        });

        $json = json_decode($response->getContent());
        $cache = Cache::get($json->id);
        $this->assertStringContainsString('Rewrite', $cache);
        $this->assertStringContainsString('Act as', $cache);
        $this->assertStringContainsString('test writer', $cache);
        $this->assertStringContainsString('Point of view', $cache);
        $this->assertStringContainsString('first person singular', $cache);
        $this->assertStringContainsString('Tone', $cache);
        $this->assertStringContainsString('humorous', $cache);
        $this->assertStringContainsString('This is a test', $cache);
    }

    public function testProcessSummarize()
    {
        UserFactory::create()->admin(true);

        foreach (['summarize', 'expand', 'paraphrase'] as $action) {
            $response = $this->post(route('boilerplate.gpt.process', [], false), [
                'tab'              => 'rewrite',
                'original-content' => 'This is a test',
                'type'             => $action,
            ]);

            $response->assertJson(function (AssertableJson $json) {
                $json->hasAll(['success', 'id'])
                    ->where('success', true)
                    ->where('id', function ($id) {
                        return preg_match('#^gpt-[a-zA-Z0-9]{16}$#', $id) !== false;
                    });
            });

            $json = json_decode($response->getContent());
            $cache = Cache::get($json->id);
            $this->assertStringContainsString(ucfirst($action), $cache);
            $this->assertStringContainsString('This is a test', $cache);
        }
    }

    public function testProcessSuggestPrepend()
    {
        UserFactory::create()->admin(true);

        foreach (['question', 'title'] as $action) {
            $response = $this->post(route('boilerplate.gpt.process', [], false), [
                'tab'              => 'rewrite',
                'original-content' => 'This is a test',
                'type'             => $action,
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
            $this->assertStringContainsString('Suggest a ' . $action, $cache);
            $this->assertStringContainsString('This is a test', $cache);
        }
    }

    public function testProcessSuggestAppend()
    {
        UserFactory::create()->admin(true);

        foreach (['conclusion', 'counterargument'] as $action) {
            $response = $this->post(route('boilerplate.gpt.process', [], false), [
                'tab'              => 'rewrite',
                'original-content' => 'This is a test',
                'type'             => $action,
            ]);

            $response->assertJson(function (AssertableJson $json) {
                $json->hasAll(['success', 'append', 'id'])
                    ->where('success', true)
                    ->where('append', true)
                    ->where('id', function ($id) {
                        return preg_match('#^gpt-[a-zA-Z0-9]{16}$#', $id) !== false;
                    });
            });

            $json = json_decode($response->getContent());
            $cache = Cache::get($json->id);
            $this->assertStringContainsString('Suggest a ' . $action, $cache);
            $this->assertStringContainsString('This is a test', $cache);
        }
    }

    public function testProcessGrammar()
    {
        UserFactory::create()->admin(true);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'tab'              => 'rewrite',
            'original-content' => 'This is a test',
            'type'             => 'grammar',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'id'])
                ->where('success', true)
                ->where('id', function ($id) {
                    return preg_match('#^gpt-[a-zA-Z0-9]{16}$#', $id) !== false;
                });
        });

        $json = json_decode($response->getContent());
        $cache = Cache::get($json->id);
        $this->assertStringContainsString('Correct grammar and spelling', $cache);
        $this->assertStringContainsString('This is a test', $cache);
    }

    public function testProcessTranslateNoLanguage()
    {
        UserFactory::create()->admin(true);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'tab'              => 'rewrite',
            'original-content' => 'This is a test',
            'type'             => 'translate',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'tab', 'html'])
                ->where('success', false)
                ->where('tab', 'gpt-rewrite')
                ->where('html', function ($html) {
                    return strstr($html, 'The Language field is required') !== false;
                });
        });
    }

    public function testProcessTranslate()
    {
        UserFactory::create()->admin(true);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'tab'              => 'rewrite',
            'original-content' => 'This is a test',
            'type'             => 'translate',
            'language'         => 'fr',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'id'])
                ->where('success', true)
                ->where('id', function ($id) {
                    return preg_match('#^gpt-[a-zA-Z0-9]{16}$#', $id) !== false;
                });
        });

        $json = json_decode($response->getContent());
        $cache = Cache::get($json->id);
        $this->assertStringContainsString('Act as a professionnal translator. Translate', $cache);
        $this->assertStringContainsString('This is a test', $cache);
    }
}
