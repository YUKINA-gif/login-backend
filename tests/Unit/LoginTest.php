<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class LoginTest extends TestCase
{
    /**
     * データベース準備
     *
     * @return void
     *
     */
    public function setUp(): void
    {
        parent::setUp();
        $user = [
            "name" => "test",
            "email" => "test@test.com",
            "password" => Hash::make("testtest"),
            "profile" => "Hello World"
        ];

        DB::table("users")->insert($user);
    }

    /**
     * ログインテスト
     * 
     * 正常系
     *
     * @return void
     * @test
     */
    public function 正常系_ステータスコード200_login_post()
    {
        $user_data = [
            "email" => "test@test.com",
            "password" => "testtest",
        ];
        $response = $this->post("api/login", $user_data);
        $response->assertStatus(200)->assertJsonFragment([
            "auth" => true
        ]);
    }

    /**
     * データリフレッシュ
     * 
     * @return void
     */
    public function tearDown(): void
    {
        Artisan::call('migrate:refresh');
        parent::tearDown();
    }

}
