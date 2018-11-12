## P3 Peer Review

+ Reviewer's name: Andrew Rodriguez
+ Reviwee's name: Haogang S
+ URL to Reviewe's P3 Github Repo URL: <https://github.com/xmansimon/laravel-app>

## 1. Interface

### What are your initial impressions of the site interface?
Simple and nicely organized. Navigation worked as expected and I immediately knew where to go and what to do to fill out the form.

### Were there any parts of the interface that you found confusing, or did not work as you expected?

When submitting the form the results show:
```
Suggested name based on your inputs: 
Birth year: 1993 ; Gender: male and your personality
Kaden
Marcus
```
I believe you should have listed out all the fields selected but personality field `and personality ambitious` did not show.

I felt the description didn't give me much insight on how the generator works - so when I got Marcus I wasn't sure why or how that result was created.

### Were there any parts of the interface that you thought worked notably well?
Navigation

Error handling and populating inputs in the form after an error 

### Do you have any suggestions for improvements on the interface?
#### Minor CSS issues
+ Top navigation bar has some spacing above - should probably have that aligned to top
Functionality:
+ Contact page shows: `For information or help, please email .` and there is no email
+ In the html for the year input you could add `type='number'` which will not allow text inputs. 
+ In the html for the year input consider adding a `placeholder='Enter year here...'` 
+ Very minor - the gender error message says: `The sex field is required.` I'd push to stay consistent with the field names so change to `The gender field is required`
+ Very minor - Results could've had a little more styling.
+ Usage of `<title>` Components were confusing - Generator page showed "Search"

## 2. Functional testing
### Test cases
+ Birth year empty : Showed correct error message
+ Not selecting a gender : Showed correct error message
+ Entering a decimal for year : Shows correct error `Year must be an integer`
+ Tested a simple XSS on input field `<script>alert('hello');</script>` : Showed correct error message
+ Tested url http://p3.ceeker.me/geez : Showed 404 correctly

## 3. Code: Routes
Routes look good using `Route::view('...')` for static pages is a good pattern.

`Route::get('/', 'WelcomeController');` could have also been changed to `Route::view('/', 'index);` since the Controller method just returns a view.


## 4. Code: Views
Imported bootstrap but didn't capitalize on the styling of components - consider checking out this guide:
[Boostrap forms](https://getbootstrap.com/docs/4.0/components/forms/) to style components like the dropdown nicer.

Consider changing `name` in `.env` file to `Name generator` so that `<title>@yield('title', config('app.name'))</title>` works as expected

Layout file has `@stack('head')` but in none of the child templates do any styling get pushed on that stack. I'd consider removing it all together if its not used.

Layout file contains remnants of Foobooks - consider removing comments/code related to foobooks to clean up the project

Consider using template layout linter/styling. There are some simple alignment issues that could be fixed with PhpStorm's Reformat code

In the code snippet below from generator.blade.php 
```
    @if(!empty($searchResults))
    ...
    @else

    @endif
```
Consider removing the @else since the else code block is empty and just do:
```
    @if(!empty($searchResults))
    ...
    @endif
```

Minor note: Consider using margins/padding instead of `<br>` br's leave space dependent on the line height css parameter that could lead to unexpected styling issues.

Consider using the null coalescing operator instead of
```
{{(old('personality') == "1")? 'selected' : ''}}
```

In `'{{ ($personality) }}'` parenthesis are not needed

In `description.blade.php` consider always having a top level component like a div instead of just text.

## 5. Code: General
NameController.php contains comments related to Foobooks as well as methods like which aren't relevant to this project
```
public function show($title)
{
    return view('books.show')->with(['title' => $title]);
}
```
Consider using ReformatCode from PhPStorm to organize the code better. Theres a couple places where there are 3 or more new lines where there should only be 1 empty line between statements.

Year, sex and personality are required by the validators so theres no need to add a default value
`$year = $request->input('year', null);` can be `$year = $request->input('year');`

Consider simplifying this conditional:
```
if ($year > 1990) {
    if ($name['year'] > 1990) {
        array_push($bdayarray, $n);
    }

} else {
    if ($name['year'] < 1990) {
        array_push($bdayarray, $n);
    }
}
```
to:
```
if ($year > 1990 && $name['year] > 1990) {
    array_push($bdayarray, $n);
} else {
    array_push($bdayarray, $n);
}
```

Consider simplifying this conditional:
```
if ($sex == 'male') {
    if ($name['sex'] == 'male') {
        array_push($sexarray, $n);
    }
} else {
    if ($name['sex'] == 'female') {
        array_push($sexarray, $n);
    }
}
```
to:
```
if ($sex == $name['sex]) {
    array_push($sexarray, $n);
}
```

Consider simplifying this condition:
```
if ($personality % 3 == 0) {
    if ($name['personality'] == 1) {
        array_push($personalityarray, $n);
    }
} else if ($personality % 3 == 1) {
    if ($name['personality'] == 2) {
        array_push($personalityarray, $n);
    }
} else if ($personality % 3 == 2) {
    if ($name['personality'] == 3) {
        array_push($personalityarray, $n);
    }
}
```
to:
```
if (($personality + 1) % 3 == $name['personality']) {
   array_push($personalityarray, $n);
}
```

For personality validation consider
`'personality' => 'required|between:1,6'`

## 6. Misc
Overall the project was really good - I thought the generator functionality was clever!
