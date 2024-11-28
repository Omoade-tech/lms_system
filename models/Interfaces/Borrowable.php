<?
// models/Interfaces/Borrowable.php
namespace App\Models\Interfaces;

interface Borrowable {
    public function borrow($studentId);
    public function returnItem($studentId);
}