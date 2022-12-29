# Constants

> {primary.fa fa-info-circle}Imagine that in the future you decide that the "approved"-status should not be represented by the string "APPROVED", but you want to switch to numerics (draft=0, approved=1, and so on). Using constants, you would only have to change it in exactly one place instead of having to remember and/or hunt down all the places where you check the status. Now imagine you're not working on a project alone, but with 50 or 100 people, so you didn't even write all the codepieces that check this status. Would be very frustrating having to locate all the places and then changing the string there. That's why it's good practice to use constants. Whenever you have a string in your code, it's worth stopping and thinking about if you really need a plain string there. Same goes for numbers. These are called "magic" strings and numbers, and in most companies, your code won't pass QA with them.

---

Example on `Role` model
```php
// Model
public const Member = 'member';

// Outside model, e.g: Controller
if ($user->role === Role::Member) {
    //
}
```
---

> {success.fa fa-check-circle} Do This

```php
// Model
public const STATUS_APPROVED = 'approved';
public const STATUS_ONGOING = 'ongoing';
public const STATUS_REJECTED = 'rejected';

// Outside model, e.g: Action / Service / Controller / etc
if ($status === Model::STATUS_APPROVED) {
    // ...
} else if ($status === Model::STATUS_ONGOING) {
    // ..
} else if ($status === Model::STATUS_REJECTED) {
    // ..
} else {
    // ..
}
```

---

> {danger.fa fa-exclamation-triangle} Don't Do This

```php
if ($status === 'approved') {
    // ...
} else if ($status === 'ongoing') {
    // ..
} else if ($status === 'rejected') {
    // ..
} else {
    // ..
}
```