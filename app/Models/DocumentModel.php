<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentModel extends Model
{
    use HasFactory;
    protected $table = 'Worker.temp_worker_documents';
    protected $primaryKey = 'id';
    protected $fillable = ['worker_id','id_proof','residential_proof','age_proof_id','age_proof','certificate_id',
        'certificate_proof','certificate_proof','passbook_xerox_proof','passport_image','thumb_image','bank_passbook',
        'address_proof','declaration_file','id_proof_ext','res_proof_ext','age_proof_ext','certificate_proof_ext','bank_passbook_ext'];
}
