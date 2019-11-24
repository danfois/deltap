<?php

namespace AppBundle\Helper\DataImport;
use Doctrine\Common\Persistence\ObjectManager;

class DataImportHelper
{
    CONST CUSTOMER = "customer";
    CONST PROVIDER = "provider";
    CONST VEHICLE = "vehicle";
    CONST EMPLOYEE = "employee";
    CONST CATEGORY = "category";

    static public function getInstance($file, String $className, ObjectManager $em) : AbstractImportHelper
    {
        switch($className) {
            case self::CUSTOMER:
                return new CustomerImportHelper($file, $em);
                break;
            case self::PROVIDER:
                return new ProviderImportHelper($file, $em);
                break;
            case self::CATEGORY:
                return new CategoryImportHelper($file, $em);
                break;
            case self::VEHICLE:
                return new VehicleImportHelper($file, $em);
                break;
            case self::EMPLOYEE:
                return new EmployeeImportHelper($file, $em);
                break;
            default:
                return null;
                break;
        }
    }
}