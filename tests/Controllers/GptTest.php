<?php

namespace Sebastienheyd\Boilerplate\Tests\Controllers;

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

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'html'])
                ->where('success', false)
                ->where('html', function ($html) {
                    return strstr($html, 'The Topic field is required.') !== false;
                });
        });
    }

    public function testProcessApiNoResponse()
    {
        UserFactory::create()->admin(true);

        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response('404', 404),
        ]);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'topic'  => 'test',
            'length' => '5',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'html'])
                ->where('success', false)
                ->where('html', function ($html) {
                    return strstr($html, 'HTTP request returned status code 404') !== false;
                });
        });
    }

    public function testProcessErrorFromAPI()
    {
        UserFactory::create()->admin(true);

        $body = json_encode(['error' => ['message' => 'API error message']]);

        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response($body, 200),
        ]);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'topic'  => 'test',
            'length' => '5',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'html'])
                ->where('success', false)
                ->where('html', function ($html) {
                    return strstr($html, 'API error message') !== false;
                });
        });
    }

    public function testProcessNoContentFromAPI()
    {
        UserFactory::create()->admin(true);

        $body = json_encode(['choices' => []]);

        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response($body, 200),
        ]);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'topic'  => 'test',
            'length' => '5',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'html'])
                ->where('success', false)
                ->where('html', function ($html) {
                    return strstr($html, 'No response from OpenAI') !== false;
                });
        });
    }

    public function testProcessContentFromAPI()
    {
        UserFactory::create()->admin(true);

        $body = json_encode(['choices' => [['message' => ['content' => 'API content message']]]]);

        Http::fake([
            'https://api.openai.com/v1/chat/completions' => Http::response($body, 200),
        ]);

        $response = $this->post(route('boilerplate.gpt.process', [], false), [
            'topic'    => 'test',
            'length'   => '5',
            'pov'      => 'first person singular',
            'tone'     => 'formal',
            'keywords' => 'test',
        ]);

        $response->assertJson(function (AssertableJson $json) {
            $json->hasAll(['success', 'content'])
                ->where('success', true)
                ->where('content', function ($html) {
                    return strstr($html, 'API content message') !== false;
                });
        });
    }
}
