## The Solution
### Question 1:
How should I save the relationship between the pivot rows of sourceable to the publications?

#### Answer:
Before proceeding with the code example, I would like to explain some important concepts to understand. I'm going to use the expression **tag** to refer to the **identifier** or **index** Morph Relations used to relate models.
The way this works, it's by assigning the tag to any Model you want to add into a relation. Any model using these tags can be store in the Morph Pivot Table. Laravel uses the _"modelable"_type_ column to filter the call on the relations storing the Model Name. You can "tag" your Model with a Relation creating a method into the Model that returns the morphToMany relation function.

For this specific case, here's how to proceed:
In your Resource Model, you have two methods, one related to the  _sourceable_ index and the other with the _publicationable_ tag using _*morphToMany*_ in return.
Here's how it's look the Resource Model (./app/Models/Resource.php):
```php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function publications()
    {
        return $this->morphToMany(Publication::class, 'publicationable')->withPivot('notes');
    }

    public function sources()
    {
        return $this->morphToMany(Source::class, 'sourceable')->withPivot(['catalog_number', 'lot_number']);
    }
}
```
In your Publication Model, you have two methods, one related to the  _sourceable_ index and the other with the _inverse relation_ with the Resource Method to the _publicationable_ tag using _*morphedByMany*_ in return.
Here's how it looks the Publication Model (./app/Models/Publication.php):
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function sources()
    {
        return $this->morphToMany(Source::class, 'sourceable')->withPivot(['catalog_number', 'lot_number']);
    }

    public function resources()
    {
        return $this->morphedByMany(Resource::class, 'publicationable');
    }
}
```
	With this, you can be able to accomplish your goal of relating Publications with Resources and Sources.

### Question 2: Can you have an intermediate table between both _sourceable_ and _publicationable_ to link to the publications?

#### Answer:
No, you don't need to. You can use the _sourceables_ table to accomplish this. You can always relate a Source with ANY model by creating the method that returns the _*morphToMany*_ relation to the Source model. These what we do with Publications on **Question 1**.

### Question 3: How to retrieve a resource with all its publications and the sources with all corresponding publications?

#### Answer:
I think Eloquent it's my favorite feature on the whole Laravel Framework. This the cherry on the cake with all we do on the Model definition.

If you check the Resource and Publication Model definition again, we add a _withPivot()_ method with the related field we want to include on any call we do to the relation with eloquent. This method made it possible to read custom values from the Pivot table.

IMPORTANT: For this example, I'm implicitly adding the pivot values because I don't declare those columns as NULL on the migrations.

To relate (Store on the Pivot table) a publication with a resource using the relation, you just need to:
##### (Using **artisan tinker**)
```shell
Psy Shell v0.10.8 (PHP 8.0.6 — CLI) by Justin Hileman
>>> $publication = \App\Models\Publication::find(5)
>>> $resource = \App\Models\Resource::find(19)
>>> $resource->publications()->attach($publication, ["notes" => "Eureka!"]);
### Adding another Publication
>>> $publication = \App\Models\Publication::find(10)
>>> $resource->publications()->attach($publication, ["notes" => "Eureka 2!"]);
```

##### (Using a Controller)
```php
use App\Models\Resource;
use App\Models\Publication;
...
$id_resource = 1; // This is the Resource Id you want to reach.
$id_publication = 10; // This is the Resource Id you want to reach.

$resource = Resource::find($id_resource);
$publication = Publication::find($id_publication);
$pivotData = [ "notes" => "Eureka!" ];

$resource->publications()->attach($publication, $pivotData);
```

To retrieve all publications from a resource, you just need to:
##### (Using **artisan tinker**)
```shell
Psy Shell v0.10.8 (PHP 8.0.6 — CLI) by Justin Hileman
>>> $resource = \App\Models\Publication::find(5)
>>> $resource->publications()->get();
```
Easy right? :) Eloquent POWER!

##### (Using a Controller)
```php
use App\Models\Resource;
...
$id_resource = 1; // This is the Resource Id you want to reach.
$resource = Resource::find($id_resource);

$resource->publications()->get();
```

Just in case of any doubt, this is how you can store and retrieve from all the models:

##### (Using a Controller)
```PHP
use App\Models\Publication;
use App\Models\Resource;
use App\Models\Source;
...
... Method ...
$id_publication = 1;
$id_resource = 1;
$id_source = 1;

$publication = Publication::find($id_resource);
$resource = Resource::find($id_resource);
$source = Source::find($id_resource);

$publicationPivotColumns = [
	"notes" => "This is a note...",
];

$sourcePivotColumns = [
	"catalog_number" => 100,
	"lot_number" => 4903,
];

// Storing Data
// Attach (Store in the publicationables table) a Publication to a Resource
$resource->publications()->attach($publication, $publicationPivotColumns);

// Attach (Store in the sourceables table) a Source to a Resource
$resource->sources()->attach($source, $sourcePivotColumns);

// Attach (Store in the sourceables table) a Source to a Publication
$publication->sources()->attach($source, $sourcePivotColumns);

// Retraiving Data
// Get all Sources from a Resource
$resource->sources()->get();

// Get all Publications from a Resource
$resource->publications()->get();

// Get all Sources from a Publication
$publication->sources()->get();
```

