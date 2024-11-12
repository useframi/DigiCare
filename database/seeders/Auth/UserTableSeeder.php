<?php

namespace Database\Seeders\Auth;

use App\Events\Backend\UserCreated;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use App\Models\Address;
/**
 * Class UserTableSeeder.
 */
class UserTableSeeder extends Seeder
{
    /**
     * Run the database seed.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();

        // Add the master administrator, user id of 1
        $avatarPath = config('app.avatar_base_path');


        $users = [
            [
                'first_name' => 'Super',
                'last_name' => 'Admin',
                'email' => 'admin@kivicare.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 81859861',
                'date_of_birth' => '1990-08-17',
                'profile_image' => public_path('/dummy-images/profile/admin/super_admin.png'),
                'avatar' => $avatarPath.'male.webp',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'admin',
            ],
            [
                'first_name' => 'Ivan',
                'last_name' => 'Norris',
                'email' => 'demo@kivicare.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 74858414',
                'date_of_birth' => '1989-02-08',
                'profile_image' => public_path('/dummy-images/profile/admin/demo_admin.png'),
                'avatar' => $avatarPath.'male.webp',
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'demo_admin',
            ],

            //vendor 
[
                'first_name' => 'Liam',
                'last_name' => 'Long',
                'email' => 'vendor@kivicare.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 8574965162',
                'date_of_birth' => '1986-05-07',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/user/liam.png'),
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'vendor',
            ],
            [
                'first_name' => 'Susan',
                'last_name' => 'Williams',
                'email' => 'susan@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 2381547861',
                'date_of_birth' => '1984-10-05',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/vendor/susan.png'),
                'gender' => 'Female',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'vendor',
            ],
            [
                'first_name' => 'Roberto',
                'last_name' => 'Gorden',
                'email' => 'roberto@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 1241547857',
                'date_of_birth' => '1982-01-12',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/vendor/roberto.png'),
                'gender' => 'Male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'vendor',
            ],
            [
                'first_name' => 'Richard',
                'last_name' => 'Howard',
                'email' => 'richard@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 7481547856',
                'date_of_birth' => '1990-01-21',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/vendor/richard.png'),
                'gender' => 'Male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'vendor',
            ],
            [
                'first_name' => 'Ken',
                'last_name' => 'Simon',
                'email' => 'ken@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 7485841458',
                'date_of_birth' => '1989-04-04',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/vendor/ken.png'),
                'gender' => 'Male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'vendor',
            ],
            [
                'first_name' => 'Deborah',
                'last_name' => 'Thomas',
                'email' => 'deborah@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 1475478605',
                'date_of_birth' => '1992-01-29',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/vendor/deborah.png'),
                'gender' => 'Female',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'vendor',
            ],


            //user

            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'john@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 4578952512',
                'date_of_birth' => '1994-01-21',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/user/john.png'),
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
            ],
            [
                'first_name' => 'Robert',
                'last_name' => 'Martin',
                'email' => 'robert@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 7485961545',
                'date_of_birth' => '1964-10-05',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/user/robert.png'),
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
            ],
            [
                'first_name' => 'Bentley',
                'last_name' => 'Howard',
                'email' => 'bentley@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 2563987448',
                'date_of_birth' => '2001-01-19',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/user/bentley.png'),
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
            ],
            [
                'first_name' => 'Brian',
                'last_name' => 'Shaw',
                'email' => 'brian@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 3565478912',
                'date_of_birth' => '1990-01-20',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/user/brian.png'),
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
            ],
            [
                'first_name' => 'Gilbert',
                'last_name' => 'Adams',
                'email' => 'gilbert@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 5674587110',
                'date_of_birth' => '1969-08-03',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/user/gilbert.png'),
                'gender' => 'male',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
            ],
            [
                'first_name' => 'Pedra',
                'last_name' => 'Danlel',
                'email' => 'pedra@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 6589741258',
                'date_of_birth' => '1981-09-25',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/user/pedra.png'),
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
            ],
            [
                'first_name' => 'Diana',
                'last_name' => 'Norris',
                'email' => 'diana@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 5687412589',
                'date_of_birth' => '1997-03-07',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/user/diana.png'),
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
            ],
            [
                'first_name' => 'Stella',
                'last_name' => 'Green',
                'email' => 'stella@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 6352897456',
                'date_of_birth' => '1998-07-09',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/user/stella.png'),
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
            ],
            [
                'first_name' => 'Lisa',
                'last_name' => 'Lucas',
                'email' => 'lisa@gmail.com',
                'password' => Hash::make('12345678'),
                'mobile' => '+1 3652417895',
                'date_of_birth' => '1991-04-30',
                'avatar' => null,
                'profile_image' => public_path('/dummy-images/profile/user/lisa.png'),
                'gender' => 'female',
                'email_verified_at' => Carbon::now(),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
                'user_type' => 'user',
            ],


        ];

        if (env('IS_DUMMY_DATA')) {
            foreach ($users as $key => $user_data) {
                $featureImage = $user_data['profile_image'] ?? null;
                $userData = Arr::except($user_data, ['profile_image','address']);
                $user = User::create($userData);

                if (isset($user_data['address'])) {
                  $addresses = $user_data['address'];

                  foreach($addresses as $addressData){
                      $address = new Address($addressData);
                      $user->address()->save($address);
                  }
                }

                $user->assignRole($user_data['user_type']);


                event(new UserCreated($user));
                if (isset($featureImage)) {
                    $this->attachFeatureImage($user, $featureImage);
                }
            }
            if (env('IS_FAKE_DATA')) {
              User::factory()->count(30)->create()->each(function ($user){
                $user->assignRole('user');
                $img = public_path('/dummy-images/user/customers/'.fake()->numberBetween(1,13).'.webp');
                $this->attachFeatureImage($user, $img);
              });
            }
        }

          Schema::enableForeignKeyConstraints();
      }

      private function attachFeatureImage($model, $publicPath)
      {
          if(!env('IS_DUMMY_DATA_IMAGE')) return false;

          $file = new \Illuminate\Http\File($publicPath);

          $media = $model->addMedia($file)->preservingOriginal()->toMediaCollection('profile_image');

          return $media;
      }
}
