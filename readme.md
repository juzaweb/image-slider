# Image Slider for Juzaweb CMS

Create Image slider for Website. This module provides a simple way to manage and display image sliders on your Juzaweb CMS website.

## Installation

You can install the module via composer:

```bash
composer require juzaweb/image-slider
```

## Usage in Admin Dashboard

* Login to Admin dashboard.  
* Goto **Appearance » Slider**.  
* Click **Add new** to add new slider or **Click name slider** to edit slider.  
* Click **Add new banner** to add new image to slider.  
![Slider setting](https://mymo-docs.juzaweb.com/assets/img/slider-1.PNG)

  *   Title
  *   Description
  *   Url (Url open when click to slider)
  *   Open new tab (Open new tab when click to link)

## Usage in Frontend

You can retrieve the slider and its items using the `ImageSlider` model.

```php
use Juzaweb\Modules\ImageSlider\Models\ImageSlider;

// Retrieve the slider by its name and load the associated items
$slider = ImageSlider::with('items')->where('name', 'slider-name')->first();

if ($slider) {
    foreach ($slider->items as $item) {
        // Access item properties
        // echo $item->title;
        // echo $item->description;
        // echo $item->image;
    }
}
```
