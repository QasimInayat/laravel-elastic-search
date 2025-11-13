## Document
<pre>\documents\Elastic Search with Scout.pdf</pre>


## Document
<p>Edit config/elasticsearch.yml</p>
<pre>
xpack.security.enabled: false
xpack.security.enrollment.enabled: false
</pre>
<pre>
composer require elasticsearch/elasticsearch
</pre>
<pre>
composer require symfony/psr-http-message-bridge
</pre>
<pre>
composer require nyholm/psr7
</pre>
<pre>
composer require laravel/scout
</pre>
<pre>
composer require babenkoivan/elastic-scout-driver-plus
</pre>
<pre>
php artisan vendor:publish --provider="Laravel\Scout\ScoutServiceProvider"
</pre>
<p>
if not importin then<br>
if it is working<br>
php artisan scout:import "App\Models\Product"       
</p>
<pre>
composer remove babenkoivan/elastic-scout-driver-plus
</pre>
<pre>
composer require babenkoivan/elastic-scout-driver
</pre>
<pre>
php artisan scout:import "App\Models\Product"
</pre>


