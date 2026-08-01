<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\Request;

trait ValidatesImageUploads
{
    protected function assertValidImage(Request $request, string $field = 'image', bool $required = true)
    {
        $request->validate([
            $field => ($required ? 'required|' : 'nullable|') . 'image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);
    }
}
