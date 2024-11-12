<?php

namespace App\Exports;

use App\Models\Property;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;


class PropertiesExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Property::with(['province', 'regency', 'district', 'village', 'lister', 'seller', 'commission'])->get()->map(function ($property) {
            return [
            'Code' => $property->code,
            'Title' => $property->title,
            'Provincy' => $property->province ? $property->province->name : 'N/A',
            'Regency' => $property->regency ? $property->regency->name : 'N/A',
            'District' => $property->district ? $property->district->name : 'N/A',
            'Village' => $property->village ? $property->village->name : 'N/A',
            'Address' => $property->address,
            'URL Map' => $property->url_map,
            'Type' => $property->type,
            'Category' => $property->category,
            'Price' => $property->price,
            'Luas Tanah' => $property->luas_tanah,
            'Luas Bangunan' => $property->luas_bangunan,
            'Jumlah Lantai' => $property->jumlah_lantai,
            'Kamar Tidur' => $property->kamar_tidur,
            'Kamar Mandi' => $property->kamar_mandi,
            'Carport' => $property->carport,
            'Listrik' => $property->listrik,
            'Legalitas Surat' => $property->sertifikat,
            'Description' => $property->description,
            'Amenities' => $property->amenities,
            'Features' => $property->features,
            'Image' => $property->image,
            'Owner Name' => $property->owner_name,
            'Owner Phone' => $property->owner_phone,
            'Owner Email' => $property->owner_email,
            'Active' => $property->active ? 'True' : 'False',
            'Sold' => $property->sold ? 'True' : 'False',
            'Sold at' => $property-> sold_at,
            'Posted by' => $property->posted_by ? $property->lister->name : 'N/A',
            'Sold by' => $property->sold_by ? $property->seller->name : 'N/A',
            'Promoted' => $property->promoted ? 'True' : 'False',
            'Premium' => $property->premium ? 'True' : 'False',
            'Deal Price' => $property->commission ? $property->commission->deal_price : 'N/A',
            'Company Commission' => $property->commission ? $property->commission->company_commission : 'N/A',
            'Listing Commission' => $property->commission ? $property->commission->listing_commission : 'N/A',
            'Selling Commission' => $property->commission ? $property->commission->selling_commission : 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            "Code",
            "Title",
            "Provincy",
            "Regency",
            "District",
            "Village",
            "Address",
            "URL Map",
            "Type",
            "Category",
            "Price",
            "Luas Tanah",
            "Luas Bangunan",
            "Jumlah Lantai",
            "Kamar Tidur",
            "Kamar Mandi",
            "Carport",
            "Listrik",
            "Sertifikat",
            "Description",
            "Amenities",
            "Features",
            "Image",
            "Owner Name",
            "Owner Phone",
            "Owner Email",
            "Active",
            "Sold",
            "Sold AT",
            "Posted by",
            "Sold by",
            "Promoted",
            "Premium",
            'Deal Price',
            'Company Commision',
            'Listing Commision',
            'Selling Commision',
        ];
    }
}
