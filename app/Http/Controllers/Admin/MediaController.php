<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;

class MediaController extends Controller
{
    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {}
}
