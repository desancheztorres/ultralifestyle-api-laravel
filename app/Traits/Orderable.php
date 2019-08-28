<?php

namespace App\Traits;

trait Orderable {

    public function scopeAlphabeticalOrder($query) {
        return $query->orderBy('name', 'asc');
    }

    public function scopeLatestFirst($query) {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeOldestFirst($query) {
        return $query->orderBy('created_at', 'asc');
    }
}