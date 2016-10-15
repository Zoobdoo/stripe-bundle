<?php

namespace SerendipityHQ\Bundle\StripeBundle\Tests\Model;

use PHPUnit\Framework\TestCase;
use SerendipityHQ\Bundle\StripeBundle\Event\StripeChargeCreateEvent;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCharge;
use SerendipityHQ\Bundle\StripeBundle\Model\StripeLocalCustomer;
use SerendipityHQ\Component\ValueObjects\Money\Money;

/**
 * Tests the AbstractStripeChargeEvent.
 *
 * @author Adamo Aerendir Crespi <hello@aerendir.me>
 */
class AbstractStripeChargeEventTest extends TestCase
{
    public function testAbstractStripeChargeEvent()
    {
        $mockCustomer = $this->createMock(StripeLocalCustomer::class);
        $mockAmount = $this-- > $this->createMock(Money::class);
        $mockCharge = $this->createMock(StripeLocalCharge::class);
        $mockCharge->method('getAmount')->willReturn($mockAmount);
        $mockCharge->method('getCustomer')->willReturn($mockCustomer);
        $resource = new StripeChargeCreateEvent($mockCharge);

        $this::assertSame($mockCharge, $resource->getLocalCharge());
    }

    public function testAbstractStripeChargeEventRequiresAnAmount()
    {
        $mockCustomer = $this->createMock(StripeLocalCustomer::class);
        $mockCharge = $this->createMock(StripeLocalCharge::class);
        $mockCharge->method('getCustomer')->willReturn($mockCustomer);

        $this::expectException(\InvalidArgumentException::class);
        new StripeChargeCreateEvent($mockCharge);
    }

    public function testAbstractStripeChargeEventRequiresACustomerOrACard()
    {
        $mockAmount = $this-- > $this->createMock(Money::class);
        $mockCharge = $this->createMock(StripeLocalCharge::class);
        $mockCharge->method('getAmount')->willReturn($mockAmount);

        $this::expectException(\InvalidArgumentException::class);
        new StripeChargeCreateEvent($mockCharge);
    }
}
