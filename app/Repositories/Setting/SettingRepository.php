<?php

namespace App\Repositories\Setting;

use App\Helper\Helper;
use App\Models\Setting;
use Illuminate\Support\Facades\Schema;

class SettingRepository implements SettingInterface
{
  use Helper;
  protected $color;

  public function __construct(Setting $color)
  {
    $this->color = $color;
  }

  public function getById($id)
  {
    return $this->color->findOrFail($id);
  }
  
  public function update($data, $id)
  {
    $settings = $this->color->findOrFail($id);
    
    // Filter data to only include columns that exist in the table
    $columns = Schema::getColumnListing('settings');
    $filteredData = array_filter($data, function($key) use ($columns) {
        return in_array($key, $columns);
    }, ARRAY_FILTER_USE_KEY);
    
    $settings->update($filteredData);
    return $settings->wasChanged();
  }
}
