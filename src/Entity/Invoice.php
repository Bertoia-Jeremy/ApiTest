<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass=InvoiceRepository::class)
 * @ApiFilter(OrderFilter::class)
 * @ApiResource(
 *     subresourceOperations={
 *          "api_customers_invoices_get_subresource"={
 *              "normalization_context"= {
 *                  "groups"={
 *                      "invoices_subresource"
 *                  }
 *              }
 *          }
 *     },
 *     itemOperations={
 *          "GET",
 *          "PUT",
 *          "DELETE",
 *          "increment"= {
 *              "method" = "POST",
 *              "path" = "/invoices/{id}/increment",
 *              "controller" = "App\Controller\InvoiceIncrementationController",
 *              "openapi_context" = {
 *                  "summary"= "Incrémente une facture",
 *                  "description"= "Incrémente le chrono de la facture donnée.",
 *              },
 *          },
 *      },
 *     attributes={
 *          "pagination_enabled"=true,
 *          "items_per_page"=20,
 *          "order": {"amount" : "DESC"}
 *     },
 *     normalizationContext={
 *          "groups"={"invoices_read"}
 *     },
 * )
 *
 */
class Invoice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"invoices_read", "customers_read", "invoices_subresource"})
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     * @Groups({"invoices_read", "customers_read", "invoices_subresource"})
     */
    private $amount;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"invoices_read"})
     */
    private $sent_at;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"invoices_read", "customers_read"})
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Customer::class, inversedBy="invoices")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"invoices_read"})
     */
    private $customer;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"invoices_read", "customers_read"})
     */
    private $chrono;

    /**
     * Permet de récupérer le User à qui appartient cette facture
     * @Groups({"invoices_read"})
     * @return User
     */
    public function getUser() : User
    {
        return $this->customer->getUser();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmount(): ?float
    {
        return $this->amount;
    }

    public function setAmount(float $amount): self
    {
        $this->amount = $amount;

        return $this;
    }

    public function getSentAt(): ?\DateTimeInterface
    {
        return $this->sent_at;
    }

    public function setSentAt(\DateTimeInterface $sent_at): self
    {
        $this->sent_at = $sent_at;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getChrono(): ?int
    {
        return $this->chrono;
    }

    public function setChrono(int $chrono): self
    {
        $this->chrono = $chrono;

        return $this;
    }
}
