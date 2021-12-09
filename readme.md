* * *

README
======

**A symfony 3 bundle to handle Jalali date including a date picker**

[](#user-content-install)Install
--------------------------------

*   **Install via Composer:**
```
    $ php composer require narmafzam/jalali-date-bundle
```

*   **Add to AppKernel:**
```
class AppKernel extends Kernel
{
 public function registerBundles()
 {
 $bundles \= array(
 new Narmafzam\\JalaliDateBundle\\NarmafzamJalaliDateBundle(),
 }
}
```

*   **install assets:**
```
    $ php app/console assets:install
```

[](#user-content-service)Service
--------------------------------

**Service Name:** narmafzam.j\_date\_service

**Functions:**

*   **georgianToPersian:**  
    Convert Georgian calendar (DateTime) To Persian (String).  
    _**Parameters:**_
    *   georgian: DateTime (default: `null`)
    *   format: string (default: `yyyy/MM/dd`) [View Intl Format](http://userguide.icu-project.org/formatparse/datetime)
    *   locale: string (default: `fa`) (e.g. fa, fa\_IR, en, en\_US, en\_UK, ...)
    *   calendar: string (default: `persian`) (e.g. gregorian, persian, islamic, ...)
    *   latinizeDigit: bool (default: `false`) Convert Persian numbers to Latin Numbers.
*   **persianToGeorgian:**  
    Convert Persian calendar (String) To Georgian (DateTime).  
    _**Parameters:**_
    *   persian: string
    *   format: string (default: `yyyy/MM/dd`) [View Intl Format](http://userguide.icu-project.org/formatparse/datetime)
    *   locale: string (default: `fa`) (e.g. fa, fa\_IR, en, en\_US, en\_UK, ...)
    *   calendar: string (default: `persian`) (e.g. gregorian, persian, islamic, ...)
*   **intlDateTimeInstance:**  
    Return new Instance of IntlDateTime. [Visit Blog of Ali Farhadi](http://farhadi.ir/blog/1389/02/10/persian-calendar-for-php-53/)

**Sample:**
```
$shamsiString \= $this\->get('narmafzam.j\_date\_service')\->georgianToPersian(new \\DateTime(), 'yyyy-MM-dd E');
//result: ۱۳۹۴-۱۱-۲۲ دوشنبه
$shamsiString \= $this\->get('narmafzam.j\_date\_service')\->persianToGeorgian('1394-11-22 دوشنبه', 'yyyy-MM-dd E');
//result: An instance of DateTime
```

[](#user-content-twig)Twig
--------------------------

**Functions:**

*   **gpDate:**  
    Convert Georgian calendar (DateTime) To Persian (String).  
    _**Parameters:**_
    *   georgian: DateTime (default: `null`)
    *   format: string (default: `yyyy/MM/dd`) [View Intl Format](http://userguide.icu-project.org/formatparse/datetime)
    *   locale: string (default: `fa`) (e.g. fa, fa\_IR, en, en\_US, en\_UK, ...)
    *   calendar: string (default: `persian`) (e.g. gregorian, persian, islamic, ...)
    *   latinizeDigit: bool (default: `false`) Convert Persian numbers to Latin Numbers.
*   **pgDate:**  
    Convert Persian calendar (String) To Georgian (DateTime).  
    _**Parameters:**_
    *   persian: string
    *   format: string (default: `yyyy/MM/dd`) [View Intl Format](http://userguide.icu-project.org/formatparse/datetime)
    *   locale: string (default: `fa`) (e.g. fa, fa\_IR, en, en\_US, en\_UK, ...)
    *   calendar: string (default: `persian`) (e.g. gregorian, persian, islamic, ...)

**Sample:**
```
{{ date|gpDate }} <br\>
{{ date|gpDate('yyyy-MM-dd E') }} <br\>
{{ '1394/11/22'|gpDate }} <br\>
{{ '1394-11-22 دوشنبه'|gpDate('yyyy-MM-dd E') }} <br\>
```

[](#user-content-form)Form
--------------------------

**Type Name:** NarmafzamDateType

**Parameters:**

*   serverFormat: string (default: `yyyy/MM/dd`) [View Intl Format](http://userguide.icu-project.org/formatparse/datetime)
*   clientFormat: string (default: `yy/m/d`) [View DatePicker Format](https://api.jqueryui.com/datepicker/#utility-formatDate)
*   attr: array  
    You can add other DatePicker options to this param, but must change uppercase letters to lower and add dash before it. (see Samples)

_**note:**_ Result of serverFormat and clientFormat, must be the same.

**Sample:**

```
$builder
 \->add('date', NarmafzamJalaliDateType::class, \[
 'serverFormat' \=> 'yyyy/MM/dd',
 'pickerOptions' \=> \[
 'Format' \=> 'yyyy/MM/dd',
 'EnableTimePicker' \=> true,
 'GroupId' \=> 'group1',
 'FromDate' \=> true,
 'DisableBeforeToday' \=> true,
 \]
 \])
 \->add('date2', NarmafzamJalaliDateType::class, \[
 'serverFormat' \=> 'yyyy-MM-dd E',
 'pickerOptions' \=> \[
 'Format' \=> 'yyyy/MM/dd',
 'EnableTimePicker' \=> true,
 'GroupId' \=> 'group1',
 'ToDate' \=> true,
 \]
 \])
 ```

[](#user-content-date-picker)Date Picker
----------------------------------------

**Requirements:**

*   Bootstrap
*   Jquery

**Add this lines to head tag in `base.html.twig` file:**
```
<head\>
    ...
    <link rel\="stylesheet" href\="{{ asset('bundles/narmafzam/jalali-date/MdBootstrapPersianDateTimePicker/css/jquery.Bootstrap-PersianDateTimePicker.css') }}" />
    ...
</head\>
```

**Add this lines to end of body tag in `base.html.twig` file:**
```
<script type\="text/javascript" src\="{{ asset('bundles/narmafzam/jalali-date/MdBootstrapPersianDateTimePicker/js/jalaali.js') }}"\></script\>
<script type\="text/javascript" src\="{{ asset('bundles/narmafzam/jalali-date/MdBootstrapPersianDateTimePicker/js/jquery.Bootstrap-PersianDateTimePicker.js') }}"\></script\>
```

**Add this lines to `app/config.yml` file:**
```
twig:
    form\_themes:
        - 'NarmafzamJalaliDateBundle:Form:form\_s\_date.html.twig'
```

**References:**

*   [View Intl Format](http://userguide.icu-project.org/formatparse/datetime)
*   [Class Intldateformatter](https://php.net/manual/en/class.intldateformatter.php)
*   [MD.BootstrapPersianDateTimePicker](https://github.com/Mds92/MD.BootstrapPersianDateTimePicker)
