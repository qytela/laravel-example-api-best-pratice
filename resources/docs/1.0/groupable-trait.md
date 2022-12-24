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

Example, using `eligibleGroups(Model)`

```php
use App\Traits\GroupableTrait;

class YourClass
{
    use GroupableTrait;

    // ... IoC Container

    public function index(): ModelResources
    {
        return new ModelResources(
            $this->eligibleGroups($this->model)->get()
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
    use GroupableTrait;

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