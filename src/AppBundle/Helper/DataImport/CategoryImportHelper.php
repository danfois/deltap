<?php

namespace AppBundle\Helper\DataImport;

use AppBundle\Entity\Category;
use Exception;

class CategoryImportHelper extends AbstractImportHelper
{
    public function import()
    {
        $this->startImportProcess();
    }

    protected function startImportProcess()
    {
        $csv = $this->reader->setHeaderOffset(0);
        $csv->setDelimiter(';');

        foreach ($csv as $c) {
            try {
                $category = new Category();
                $category->setCategoryName($c['Tipologia']);

                $this->em->persist($category);
                $this->persist();
                $this->success[] = $c['Tipologia'];

            } catch (Exception $e) {
                $this->em = $this->em->create(
                    $this->em->getConnection(),
                    $this->em->getConfiguration(),
                    $this->em->close()
                );
                $this->errors[] = $c['Tipologia'];
                continue;
            }
        }
    }

    protected function persist()
    {
        $this->em->flush();
        $this->em->clear();
    }
}