<?php

namespace AppBundle\Controller\DataImport;
use AppBundle\Helper\DataImport\DataImportHelper;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ImportController extends Controller
{
    /**
     * @Route("/import-{entityName}", name="import_data")
     */
    public function importCustomersAction(Request $request, String $entityName)
    {
        $allowedImports = array(
            'customers' => array(
                'slug' => 'Clienti',
                'dataImportType' => DataImportHelper::CUSTOMER
            ),
            'providers' => array(
                'slug' => 'Fornitori',
                'dataImportType' => DataImportHelper::PROVIDER
            ),
            'vehicles' => array(
                'slug' => 'Veicoli',
                'dataImportType' => DataImportHelper::VEHICLE
            ),
            'employees' => array(
                'slug' => 'Dipendenti',
                'dataImportType' => DataImportHelper::EMPLOYEE
            ),
            'categories' => array(
                'slug' => 'Categorie',
                'dataImportType' => DataImportHelper::CATEGORY
            )
        );

        if(!isset($allowedImports[$entityName]) || $allowedImports == null) return new Response("Pagina non trovata", 404);

        $file = $request->files->get('importData');

        if(isset($file) && $file != null) {
            $file = $file->openFile();
            $ImportHelper = DataImportHelper::getInstance($file, $allowedImports[$entityName]['dataImportType'], $this->getDoctrine()->getManager());
            $ImportHelper->import();

            $success = $ImportHelper->getSuccess();
            $errors = $ImportHelper->getErrors();

            $errorMessage = 'Le seguenti entità non sono state importate:<br /><ul>';

            foreach ($errors as $e) {
                $errorMessage .= '<li>' . $e . '</li>';
            }

            $errorMessage .= '</ul>';

            return $this->render('data_import/data_import.html.twig', array(
                'entity_to_import' => $allowedImports[$entityName]['slug'],
                'successful_import' => count($success) > 0,
                'error_import' => count($errors) > 0,
                'error_message' => $errorMessage
            ));
        } else {
            return $this->render('data_import/data_import.html.twig', array(
                'entity_to_import' => $allowedImports[$entityName]['slug'],
                'successful_import' => false,
                'error_import' => false,
                'error_message' => ''
            ));
        }
    }
}