<?php

namespace AppBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(name="categories")
 */
class Category
{
    /**
     * @ORM\Column(type="integer", name="category_id")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $categoryId;

    /**
     * @ORM\Column(type="string", length=64, nullable=false)
     * @Assert\NotBlank(message="Please insert a valid category name")
     * @Assert\Length(max=64, maxMessage="Category Name is too long. Max 64 characters")
     */
    private $categoryName;
}