<?php

namespace CoreData\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Modules\CoreData\Http\Controllers\CategoryController;
use Modules\CoreData\Repositories\CategoryRepository;
use Modules\CoreData\Service\CategoryService;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CategoryControllerTest extends TestCase
{

    /**
     * @throws Exception
     */
    public function testImportView()
    {
        $repository = new CategoryRepository(app());
        $CategoryService = new CategoryService($repository);
        $categoryController = new CategoryController($CategoryService);
        $request = new Request;
        try {
            $categoryController->importView($request);
        }
        catch (NotFoundExceptionInterface|ContainerExceptionInterface $e) {}
    }
}
