<?php

namespace Sunnysideup\PaymentHirePurchase;

use Override;
use SilverStripe\Core\Config\Config;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\Form;
use SilverStripe\Forms\HiddenField;
use SilverStripe\Forms\LiteralField;
use Sunnysideup\Ecommerce\Model\Money\EcommercePayment;
use Sunnysideup\Ecommerce\Model\Order;
use Sunnysideup\Ecommerce\Money\Payment\PaymentResults\EcommercePaymentSuccess;

/**
 * Payment object representing an Hire Purchase Payment (order online and then complete HP application externally).
 *
 */
class HirePurchasePayment extends EcommercePayment
{
    private static $table_name = 'HirePurchasePayment';

    private static $custom_message_for_in_store_payment = '';

    private static $logo = 'https://www.creditcapable.co.nz/ccl.png';

    /**
     * Process the In Store payment method.
     *
     * @param mixed $data
     */
    #[Override]
    public function processPayment($data, Form $form)
    {
        $this->Status = EcommercePayment::PENDING_STATUS;
        $this->Message = Config::inst()->get(HirePurchasePayment::class, 'custom_message_for_hire_purchase_payment');
        $this->write();

        return EcommercePaymentSuccess::create();
    }

    #[Override]
    public function getPaymentFormFields($amount = 0, ?Order $order = null): FieldList
    {
        return FieldList::create(LiteralField::create('HirePurchasePayment_BeforeMessage', '<div id="HirePurchasePayment_BeforeMessage"><img src="' . $this->Config()->get('logo') . '" alt="Online Finance provided by credit capable"></div>'), HiddenField::create('HirePurchase', 'HirePurchase', 0));
    }

    #[Override]
    public function getPaymentFormRequirements(): array
    {
        return [];
    }
}
