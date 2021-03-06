<?php
namespace App\Events;

use ApiPlatform\Core\EventListener\EventPriorities;
use App\Entity\Invoice;
use App\Repository\InvoiceRepository;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Security;

class InvoiceChronoSubscriber implements EventSubscriberInterface
{
    /**
     * @var Security
     */
    private $security;
    /**
     * @var InvoiceRepository
     */
    private $invoiceRepository;


    public function __construct(Security $security, InvoiceRepository $invoiceRepository){
        $this->security = $security;
        $this->invoiceRepository = $invoiceRepository;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['setChronoForInvoice', EventPriorities::PRE_VALIDATE]
        ];
    }

    public function setChronoForInvoice(ViewEvent $event){
        $result = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if($result instanceof Invoice && $method === "POST"){
            $user = $this->security->getUser();
            $chrono = $this->invoiceRepository->findLastChrono($user);

            if($chrono) {
                $chrono++;
            }else{
                $chrono = 0;
            }

            $result->setChrono($chrono);
        }
    }
}