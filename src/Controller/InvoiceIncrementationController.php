<?php
namespace App\Controller;

use App\Entity\Invoice;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class InvoiceIncrementationController
 * @package App\Controller
 */
class InvoiceIncrementationController{

    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * InvoiceIncrementationController constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em){
        $this->em = $em;
    }

    /**
     * @param Invoice $data
     */
    public function __invoke(Invoice $data)
    {
        $data->setChrono($data->getChrono() + 1);

        $this->em->flush();

        return $data;
    }
}