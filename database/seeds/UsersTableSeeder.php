<?php

use Illuminate\Database\Seeder;
use App\Models\Users\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'over_name' => '若松',
                'under_name' => '利水',
                'over_name_kana' => 'ワカマツ',
                'under_name_kana' => 'リスイ',
                'mail_address' => 'risui@rrr',
                'sex' => '1',
                'birth_day' => '1994-12-12', //日付の間は年月日や/(スラッシュ)ではなく-(ハイフン)
                'role' => '1',
                'password' => Hash::make('123456789w') //パスワードの暗号化
            ]
        ]);
    }
}
