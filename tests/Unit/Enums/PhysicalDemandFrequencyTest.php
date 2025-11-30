<?php

use App\Enums\PhysicalDemandFrequency;

test('physical demand frequency has correct values', function () {
    expect(PhysicalDemandFrequency::NEVER->value)->toBe(0);
    expect(PhysicalDemandFrequency::SELDOM->value)->toBe(1);
    expect(PhysicalDemandFrequency::OCCASIONAL->value)->toBe(2);
    expect(PhysicalDemandFrequency::FREQUENT->value)->toBe(3);
    expect(PhysicalDemandFrequency::CONSTANT->value)->toBe(4);
});

test('physical demand frequency has labels', function () {
    expect(PhysicalDemandFrequency::NEVER->label())->toBe('Never (not at all)');
    expect(PhysicalDemandFrequency::SELDOM->label())->toBe('Seldom (1-10% of the time)');
    expect(PhysicalDemandFrequency::OCCASIONAL->label())->toBe('Occasional (11-33% of the time)');
    expect(PhysicalDemandFrequency::FREQUENT->label())->toBe('Frequent (34-66% of the time)');
    expect(PhysicalDemandFrequency::CONSTANT->label())->toBe('Constant (67-100% of the time)');
});

test('physical demand frequency has short labels', function () {
    expect(PhysicalDemandFrequency::NEVER->shortLabel())->toBe('Never');
    expect(PhysicalDemandFrequency::FREQUENT->shortLabel())->toBe('Frequent');
});

test('physical demand frequency has percentages', function () {
    expect(PhysicalDemandFrequency::NEVER->percentage())->toBe('0%');
    expect(PhysicalDemandFrequency::SELDOM->percentage())->toBe('1-10%');
    expect(PhysicalDemandFrequency::OCCASIONAL->percentage())->toBe('11-33%');
    expect(PhysicalDemandFrequency::FREQUENT->percentage())->toBe('34-66%');
    expect(PhysicalDemandFrequency::CONSTANT->percentage())->toBe('67-100%');
});

test('physical demand frequency can generate options array', function () {
    $options = PhysicalDemandFrequency::options();

    expect($options)->toBeArray();
    expect($options)->toHaveCount(5);
    expect($options[0])->toBe('Never (not at all)');
    expect($options[4])->toBe('Constant (67-100% of the time)');
});

test('physical demand frequency can be created from int', function () {
    $freq = PhysicalDemandFrequency::from(3);

    expect($freq)->toBe(PhysicalDemandFrequency::FREQUENT);
});
