<?php

namespace App\Console\Commands;

use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\ProductRepositoryInterface;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Console\Command;

class CreateProduct extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'create:product';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'New Product creation.';

    /**
     * Execute the console command.
     */
    private ProductRepositoryInterface $productRepository;
    private CategoryRepositoryInterface $categoryRepository;

    public function __construct(ProductRepositoryInterface $productRepository, CategoryRepositoryInterface $categoryRepository)
    {
        parent::__construct(); // Call the parent constructor

        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }
    public function handle()
    {
        try {
            $categories = $this->categoryRepository->list();

            if ($categories->isEmpty()) {
                $this->error('There are no categories created yet.');
                return;
            }

            $this->line('Select a category:');

            foreach ($categories as $index => $category) {
                $this->line(sprintf('%d. %s', $index + 1, $category->name));
            }

            $selectedCategoryIndex = null;

            do {
                $selectedCategoryIndex = $this->ask('Enter your selection:');

                if (!$selectedCategoryIndex || !is_numeric($selectedCategoryIndex) || $selectedCategoryIndex < 1 || $selectedCategoryIndex > $categories->count()) {
                    $this->error('Invalid selection. Please enter a valid selection.');
                } else {
                    break;
                }
            } while (true);

            $selectedCategory = $categories[$selectedCategoryIndex - 1];

            $productName = null;
            do {
                $productName = $this->ask('Enter the product name:');
                if (empty($productName)) {
                    $this->error('Product name cannot be empty. Please enter a valid product name.');
                } else {
                    break;
                }
            } while (true);

            $productPrice = null;
            do {
                $productPrice = $this->ask('Enter the product price:');
                if (!is_numeric($productPrice) || $productPrice <= 0) {
                    $this->error('Invalid product price. Please enter a valid numeric price.');
                } else {
                    break;
                }
            } while (true);

            $productDescription = null;
            do {
                $productDescription = $this->ask('Enter the product description:');
                if (empty($productDescription)) {
                    $this->error('Product description cannot be empty. Please enter a valid description.');
                } else {
                    break;
                }
            } while (true);

            $productImage = null;
            do {
                $productImagePath = $this->ask('Enter the product image path:');

                if (!file_exists($productImagePath) || !is_file($productImagePath)) {
                    $this->error('Invalid image path. Please provide a valid file path.');
                } else {
                    $productImage = $productImagePath;
                    break;
                }
            } while (true);
            $product = $this->productRepository->create([
                'name' => $productName,
                'price' => $productPrice,
                'description' => $productDescription,
                'category_id' => $selectedCategory->id,
                'image' => $productImage,
            ]);
            $this->info('Product created successfully.');
            $this->line('Product Info:');
            $this->table(['Name', 'Price', 'Description', 'Category', 'Image'], [$product->toArray()]);
        } catch (\Throwable $th) {
            $this->error($th->getMessage());
        }
    }
}
