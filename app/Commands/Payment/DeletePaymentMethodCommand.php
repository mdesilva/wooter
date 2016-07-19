<?php

namespace Wooter\Commands\Organization\League;

use Wooter\Commands\Command;
use Illuminate\Contracts\Bus\SelfHandling;
use Wooter\Wooter\Exceptions\DatabaseException;
use Wooter\Wooter\Exceptions\Payment\PaymentMethodNotFound;
use Wooter\Wooter\Exceptions\User\UserIsNotAdmin;
use Wooter\Wooter\Exceptions\User\UserNotFound;
use Wooter\Wooter\Repositories\Payment\PaymentMethodRepository;
use Wooter\Wooter\Repositories\User\UserRepository;

class DeletePaymentMethodCommand extends Command implements SelfHandling
{
    /**
     * @var
     */
    private $paymentMethodId;
    /**
     * @var
     */
    private $userId;

    /**
     * Create a new command instance.
     *
     * @param $payment_method_id
     * @param $user_id
     *
     */
    public function __construct($payment_method_id, $user_id)
    {

        $this->paymentMethodId = $payment_method_id;
        $this->userId = $user_id;
    }

    /**
     * Execute the command.
     *
     * @param PaymentMethodRepository|PaymentMethodRepository $paymentMethodRepository
     * @param UserRepository                                  $userRepository
     *
     * @return bool
     * @throws DatabaseException
     * @throws PaymentMethodNotFound
     * @throws UserIsNotAdmin
     * @throws UserNotFound
     */
    public function handle(PaymentMethodRepository $paymentMethodRepository, UserRepository $userRepository)
    {
        $paymentMethod = $paymentMethodRepository->getById($this->paymentMethodId);

        if ( ! $paymentMethod) {
            throw new PaymentMethodNotFound;
        }

        $user = $userRepository->getById($this->userId);

        if ( ! $user)
        {
            throw new UserNotFound;
        }

        if ( ! $user->isAdmin()) {
            throw new UserIsNotAdmin;
        }

        if ( ! $paymentMethod->delete())
        {
            throw new DatabaseException('There was an error deleting the payment method');
        }

        return true;
    }
}
