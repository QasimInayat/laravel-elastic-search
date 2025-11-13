## Installation
<pre>composer require spatie/laravel-medialibrary</pre>
<pre>php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="migrations"</pre>
<pre>php artisan migrate</pre>
<pre>php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="config"</pre>
<pre>php artisan storage:link</pre>
<p>See <a href="https://spatie.be/docs/laravel-medialibrary/v11/installation-setup">Spatie Media Library Installation and Setup Guide</a></p>
<pre>'public' => [ 'driver' => 'local', 'root' => storage_path('app/public'), 'url' => env('APP_URL').'/storage', 'visibility' => 'public', ],</pre>
<p>.env</p>
<pre>
    FILESYSTEM_DISK=public<br>
    APP_URL=http://localhost
</pre>


## Image Conversion
<pre>composer require intervention/image</pre>

<p>By default conversion will be work through Que</p>
<p>Start queue worker</p>
<pre>php artisan queue:work</pre>

<p>Or for development</p>
<pre>php artisan queue:listen</pre>
<pre>
composer require spatie/image<br>
php artisan media-library:regenerate
</pre>

