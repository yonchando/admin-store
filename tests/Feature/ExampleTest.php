<?php

it('returns a successful response', function () {

    \App\Models\Staff::factory(10)->create();

    $staffs = \App\Models\Staff::filters([
        'gender' => \App\Enums\GenderEnum::MALE,
        'status' => \App\Enums\Staff\StaffStatusEnum::ACTIVE,
    ])->withTrashed()->toRawSql();

    dd($staffs);
});
