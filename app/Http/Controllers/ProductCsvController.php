<?php
namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductCsvController extends Controller
{
    public function export()
    {
        $products = Product::all();
        $filename = 'products_export_' . now()->format('Ymd_His') . '.csv';
        $handle = fopen('php://temp', 'r+');
        fputcsv($handle, ['id', 'name', 'category', 'price', 'description', 'quantity']);
        foreach ($products as $p) {
            fputcsv($handle, [$p->id, $p->name, $p->category, $p->price, $p->description, $p->quantity]);
        }
        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);
        return response($csv)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', "attachment; filename=\"$filename\"");
    }

    public function import(Request $request)
    {
        $request->validate([
            'csv' => 'required|file|mimes:csv,txt',
        ]);
        $path = $request->file('csv')->getRealPath();
        $handle = fopen($path, 'r');
        $header = fgetcsv($handle);
        $count = 0;
        while (($row = fgetcsv($handle)) !== false) {
            $data = array_combine($header, $row);
            Product::updateOrCreate(
                ['id' => $data['id']],
                [
                    'name' => $data['name'],
                    'category' => $data['category'],
                    'price' => $data['price'],
                    'description' => $data['description'],
                    'quantity' => $data['quantity'],
                ]
            );
            $count++;
        }
        fclose($handle);
        return back()->with('success', "$count products imported/updated.");
    }
}
