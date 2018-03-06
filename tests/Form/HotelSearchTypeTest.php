<?php

namespace App\Tests\Form;

use App\Form\HotelSearchType;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormInterface;

class HotelSearchTypeTest extends KernelTestCase
{
    /** @var FormFactory */
    protected $factory;

    public function setUp()
    {
        $kernel = self::bootKernel();
        $this->factory = $kernel->getContainer()->get('form.factory');
    }

    public function testValidName()
    {
        /** @var FormInterface $form */
        $form = $this->factory->create(HotelSearchType::class);

        $form->submit([
            'name' => 'Hilton',
        ]);

        $this->assertTrue($form->isSubmitted(),'isSubmitted Error');
        $this->assertTrue($form->isSynchronized(), 'isSynchronized Error');
        $this->assertTrue($form->isValid(), 'isValid Error');
    }

    public function testValidCity()
    {
        /** @var FormInterface $form */
        $form = $this->factory->create(HotelSearchType::class);

        $form->submit([
            'city' => 'Cairo',
        ]);

        $this->assertTrue($form->isSubmitted(),'isSubmitted Error');
        $this->assertTrue($form->isSynchronized(), 'isSynchronized Error');
        $this->assertTrue($form->isValid(), 'isValid Error');
    }

    public function testValidPrice()
    {
        /** @var FormInterface $form */
        $form = $this->factory->create(HotelSearchType::class);

        $form->submit([
            'price_from' => 50.8,
            'price_to' => 101.4,
        ]);

        $this->assertTrue($form->isSubmitted(),'isSubmitted Error');
        $this->assertTrue($form->isSynchronized(), 'isSynchronized Error');
        $this->assertTrue($form->isValid(), 'isValid Error');
    }

    public function testInvalidPrice()
    {
        /** @var FormInterface $form */
        $form = $this->factory->create(HotelSearchType::class);

        $form->submit([
            'price_from' => 'invalid_price_from',
            'price_to' => 'invalid_price_to',
        ]);

        $this->assertTrue($form->isSubmitted(),'isSubmitted Error');
        $this->assertTrue($form->isSynchronized(), 'isSynchronized Error');
        $this->assertFalse($form->isValid(), 'isValid Error');
    }

    public function testValidDate()
    {
        /** @var FormInterface $form */
        $form = $this->factory->create(HotelSearchType::class);

        $form->submit([
            'date_from' => '29-12-2018',
            'date_to' => '02-01-2019',
        ]);

        $this->assertTrue($form->isSubmitted(),'isSubmitted Error');
        $this->assertTrue($form->isSynchronized(), 'isSynchronized Error');
        $this->assertTrue($form->isValid(), 'isValid Error');
    }

    public function testValidSortBy()
    {
        /** @var FormInterface $form */
        $form = $this->factory->create(HotelSearchType::class);

        $form->submit([
            'sort_by' => 'name',
        ]);

        $this->assertTrue($form->isSubmitted(),'isSubmitted Error');
        $this->assertTrue($form->isSynchronized(), 'isSynchronized Error');
        $this->assertTrue($form->isValid(), 'isValid Error');
    }

    public function testInvalidSortBy()
    {
        /** @var FormInterface $form */
        $form = $this->factory->create(HotelSearchType::class);

        $form->submit([
            'sort_by' => 'other_invalid_value',
        ]);

        $this->assertTrue($form->isSubmitted(),'isSubmitted Error');
        $this->assertTrue($form->isSynchronized(), 'isSynchronized Error');
        $this->assertFalse($form->isValid(), 'isValid Error');
    }

    public function testFullValidDataTransformationFormat()
    {
        $validData = [
            'name' => 'Hilton',
            'city' => 'Cairo',
            'price_from' => 50,
            'price_to' => 100,
            'date_from' => '05-12-2018',
            'date_to' => '10-12-2018',
            'sort_by' => 'name'
        ];

        /** @var FormInterface $form */
        $form = $this->factory->create(HotelSearchType::class);

        $form->submit($validData);

        $this->assertTrue($form->isSubmitted(),'isSubmitted Error');
        $this->assertTrue($form->isSynchronized(), 'isSynchronized Error');
        $this->assertTrue($form->isValid(), 'isValid Error');

        /** @var array $submittedData */
        $submittedData = $form->getData();

        $this->assertEquals($validData['name'],$submittedData['name']);
        $this->assertEquals($validData['city'],$submittedData['city']);
        $this->assertEquals($validData['price_from'],$submittedData['price_from']);
        $this->assertEquals($validData['price_to'],$submittedData['price_to']);
        $this->assertEquals($validData['sort_by'],$submittedData['sort_by']);
        $this->assertInstanceOf(\DateTime::class, $submittedData['date_from']);
        $this->assertEquals($validData['date_from'], $submittedData['date_from']->format('d-m-Y'));
        $this->assertInstanceOf(\DateTime::class, $submittedData['date_to']);
        $this->assertEquals($validData['date_to'], $submittedData['date_to']->format('d-m-Y'));
    }
}
