# Groupable Trait

`App\Traits\GroupableTrait.php`

> {primary.fa fa-info-circle} In simple terms Traits is a group of methods that you want to include within another class. You can easily reuse that methods to another class. Trait is save to write same code again and again.

---

- [Eligible Groups](#eligible-groups)
- [Only Groups](#only-groups)

<a name="eligible-groups"></a>

## Eligible Groups

Eligible group on user group (exclude superadmin) to according model group.

---

> {warning.fa fa-info-circle} If you want use this method, make sure you already define `groups` relation.

Example on `Article` model

Migration
```php
Schema::create('article_group', function (Blueprint $table) {
    $table->foreignIdFor(Article::class)->constrained()->onDelete('cascade');
    $table->foreignIdFor(Group::class)->constrained()->onDelete('cascade');

    $table->index(['article_id', 'group_id']);
});
```

Model
```php
public function groups()
{
    return $this->belongsToMany(Group::class, 'article_group');
}
```

Table (`article_group`)

article_id | group_id |
:-         | :-       |
1          | 1        |
2          | 2        |

Example, using `eligibleGroups(Model)`

```php
use App\Traits\GroupableTrait;

class YourClassService
{
    // Import traits
    use GroupableTrait;

    public function index(): ModelResources
    {
        return new ModelResources(
            $this->eligibleGroups($this->article)->get()
        );
    }
}
```

<a name="only-groups"></a>

## Only Groups

Returns only to the specified group.

---

Example, using `onlyGroups(Model, array)`

```php
use App\Traits\GroupableTrait;

class YourClass
{
    // Import traits
    use GroupableTrait, OtherTrait;

    // ... IoC Container

    public function index(): ModelResources
    {
        $groupIds = [1, 2, 3];
        return new ModelResources(
            $this->onlyGroups($this->model, $groupIds)->get()
        );
    }
}
```