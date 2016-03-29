<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(suo\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->email,
        'password' => bcrypt('1'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(suo\Room::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->company,
    ];
});

$factory->define(suo\Panel::class, function (Faker\Generator $faker) {
    return [
        'ip_address' => $faker->localIpv4,
        'name' => $faker->name,
        'description' => $faker->company,
    ];
});

$factory->define(suo\Terminal::class, function (Faker\Generator $faker) {
    return [
        'ip_address' => $faker->localIpv4,
        'name' => $faker->name,
        'description' => $faker->company,
    ];
});

$factory->define(suo\Check::class, function (Faker\Generator $faker) {
    return [
        'number' => $faker->numberBetween(1, 1000),
        'admission_date' => date('Y-m-d'),
    ];
});

$factory->define(suo\Ticket::class, function (Faker\Generator $faker) {
    return [
        'status' => suo\Ticket::NEWTICKET,
        'room_id' => 1,
        'check_id' => $faker->numberBetween(1, 50),
        'admission_date' => date('Y-m-d H:i:s'),
    ];
});

$factory->defineAs(suo\Ticket::class, 'ticket_closed', function (Faker\Generator $faker) use ($factory) {
    $ticket = $factory->raw(suo\Ticket::class);

    return array_merge($ticket, ['status' => suo\Ticket::CLOSED]);
});

$factory->defineAs(suo\Ticket::class, 'ticket_accepted', function (Faker\Generator $faker) use ($factory) {
    $ticket = $factory->raw(suo\Ticket::class);

    return array_merge($ticket, ['status' => suo\Ticket::ACCEPTED]);
});
