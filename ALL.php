<?php
//Controllers
//DashboardController.php
use App\Models\Grade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function listTables()
    {
        $tables = DB::select('SHOW TABLES');
        $tables = array_map('current',$tables);

        $tableCounts = [];

        foreach($tables as $table){
            $count = DB::table($table)->count();
            $tableCounts[$table] = $count;
        }

        return view('dashboard', compact('tables','tableCounts'));
    }

    public function seedDatabase()
    {

        Artisan::call('db:seed');

        return redirect()->route('dashboard')->with('success', 'Database seeded successfully.');
    }


}

//TimetableController.php
class TimetableController extends Controller
{
    public function showCards()
    {
        $cards = Card::all();

        return view('cards', compact('cards'));
    }

    public function showClasses()
    {
        $classes = Clas::all();

        $headers = ['Ora', 'Luni', 'Marti', 'Miercuri', 'Joi', 'Vineri'];
        $contents = ['[subject]','[subject]','[subject]','[subject]','[subject]'];

        return view('classes', compact('headers','contents','classes'));
    }

    public function showClassrooms()
    {
        $classrooms = Classroom::all();

        $headers = ['Ora', 'Luni', 'Marti', 'Miercuri', 'Joi', 'Vineri'];
        $contents = ['C/L/S','C/L/S','C/L/S','C/L/S','C/L/S'];

        return view('classrooms', compact('headers','contents','classrooms'));
    }

    public function showDaysdefs()
    {
        $daysdefs = Day::all();

        return view('daysdefs', compact('daysdefs'));
    }

    public function showGrades()
    {
        $grades = Grade::all();

        return view('grades', compact('grades'));
    }

    public function showGroups()
    {
        $groups = Group::all();

        return view('groups', compact('groups'));
    }

    public function showLessons()
    {
        $lessons = Lesson::all();

        return view('lessons', compact('lessons'));
    }

    public function showPeriods()
    {
        $periods = Period::all();

        return view('periods', compact('periods'));
    }

    public function showSubjects()
    {
        $subjects = Subject::all();

        return view('subjects', compact('subjects'));
    }

    public function showTeachers()
    {
        $teachers = Teacher::all();

        $headers = ['Ora', 'Luni', 'Marti', 'Miercuri', 'Joi', 'Vineri'];
        $contents = ['C/L/S','C/L/S','C/L/S','C/L/S','C/L/S'];

        return view('teachers', compact('headers','contents','teachers'));
    }

    public function showTermsdefs()
    {
        $termsdefs = Term::all();

        return view('termsdefs', compact('termsdefs'));
    }

    public function showWeeksdefs()
    {
        $weeksdefs = Week::all();

        return view('weeksdefs', compact('weeksdefs'));
    }

    public function welcome(){
        return view('welcome');
    }

    public function test(){
        return view('test');
    }

}
//Models
//Card.php
class Card extends Model
{
    protected $table='cards';

    protected $fillable = [
        'lessonid',
        'classroomids',
        'period',
        'weeks',
        'terms',
        'days',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'lessonid');
    }

    public function classroom()
    {
        return $this->belongsTo(Classroom::class, 'classroomids');
    }

    public function period()
    {
        return $this->belongsTo(Period::class, 'period');
    }

    public function day()
    {
        return $this->belongsTo(Day::class, 'days');
    }
    public function index()
    {
        $cards = Card::with(['lesson.subject', 'lesson.teacher', 'classroom', 'period', 'day'])->get();

        return view('cards', compact('cards'));
    }

}
//Clas.php
class Clas extends Model
{
    protected $table='classes';

    protected $fillable = [
        'id',
        'name',
        'short',
        'partner_id',
    ];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'class_lesson');
    }

    public function index()
    {
        $cards = Card::with(['lesson.subject', 'lesson.teacher', 'classroom', 'period', 'day'])->get();

        return view('classes', compact('cards'));
    }

}
//Classroom.php
class Classroom extends Model
{
    protected $table='classrooms';

    protected $fillable = [
        'id',
        'name',
        'short',
        'partner_id',
    ];
}
//Day.php
class Day extends Model
{
    protected $table='days';

    protected $fillable = [
        'id',
        'name',
        'short',
        'day',
    ];
}
//Group.php
class Group extends Model
{
    protected $table='groups';

    protected $fillable = [
        'id',
        'name',
        'classid',
        'entireclass',
        'divisiontag',
    ];

    public function lessons()
    {
        return $this->belongsToMany(Lesson::class, 'group_lesson');
    }

}
//Lesson.php
class Lesson extends Model
{
    protected $table='lessons';

    protected $fillable = [
        'id',
        'classids',
        'subjectid',
        'periodspercard',
        'periodsperweek',
        'teacherid',
        'groupids',
        'termsdefid',
        'weeksdefid',
        'daysdefid',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subjectid');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class, 'teacherid');
    }
}

//Period.php
class Period extends Model
{
    protected $table='periods';

    protected $fillable = [
        'name',
        'short',
        'period',
        'starttime',
        'stoptime',
    ];


}
//Subject.php
class Subject extends Model
{
    protected $table='subjects';

    protected $fillable = [
        'id',
        'name',
        'short',
        'partner_id',
    ];


}
//Teacher.php
class Teacher extends Model
{
    protected $table='teachers';

    protected $fillable = [
        'id',
        'firstname',
        'lastname',
        'name',
        'short',
    ];

}
//Term.php
class Term extends Model
{
    protected $table='terms';

    protected $fillable = [
        'id',
        'name',
        'short',
        'terms',
    ];
}
//User.php
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}

//Week.php
class Week extends Model
{
    protected $table='weeks';

    protected $fillable = [
        'id',
        'name',
        'short',
        'weeks',
    ];
}
//Components
//AppLayout.php
class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
//BackButton.php
class BackButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.back-button');
    }
}
//CardsTest.php
class CardsTest extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.cards-test');
    }
}
//ClassesButton.php
class ClassesButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.classes-button');
    }
}
//ClassroomsButton.php
class ClassroomsButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.classrooms-button');
    }
}
//GuestLayout.php
class GuestLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.guest');
    }
}
//HomeButton.php
class HomeButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.home-button');
    }
}

//LessonsButton.php
class LessonsButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.lessons-button');
    }
}
//SubjectsButton.php
class SubjectsButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.subjects-button');
    }
}

//SvgIcon.php
class SvgIcon extends Component
{
    public $path;
    public function __construct($path)
    {
        $this->path=$path;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.svg-icon');
    }
}

//TeachersButton.php
class TeachersButton extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.teachers-button');
    }
}
//config
//app.php
return [

    /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

    'name' => env('APP_NAME', 'Laravel'),

    /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

    'env' => env('APP_ENV', 'production'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => (bool) env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => env('APP_URL', 'http://localhost'),

    'asset_url' => env('ASSET_URL'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

    'faker_locale' => 'en_US',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Maintenance Mode Driver
    |--------------------------------------------------------------------------
    |
    | These configuration options determine the driver used to determine and
    | manage Laravel's "maintenance mode" status. The "cache" driver will
    | allow maintenance mode to be controlled across multiple machines.
    |
    | Supported drivers: "file", "cache"
    |
    */

    'maintenance' => [
        'driver' => 'file',
        // 'store'  => 'redis',
    ],

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Notifications\NotificationServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Package Service Providers...
         */

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        // App\Providers\BroadcastServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => Facade::defaultAliases()->merge([
        // 'ExampleClass' => App\Example\ExampleClass::class,
    ])->toArray(),

];
//auth.php
return [

    /*
    |--------------------------------------------------------------------------
    | Authentication Defaults
    |--------------------------------------------------------------------------
    |
    | This option controls the default authentication "guard" and password
    | reset options for your application. You may change these defaults
    | as required, but they're a perfect start for most applications.
    |
    */

    'defaults' => [
        'guard' => 'web',
        'passwords' => 'users',
    ],

    /*
    |--------------------------------------------------------------------------
    | Authentication Guards
    |--------------------------------------------------------------------------
    |
    | Next, you may define every authentication guard for your application.
    | Of course, a great default configuration has been defined for you
    | here which uses session storage and the Eloquent user provider.
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | Supported: "session"
    |
    */

    'guards' => [
        'web' => [
            'driver' => 'session',
            'provider' => 'users',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Providers
    |--------------------------------------------------------------------------
    |
    | All authentication drivers have a user provider. This defines how the
    | users are actually retrieved out of your database or other storage
    | mechanisms used by this application to persist your user's data.
    |
    | If you have multiple user tables or models you may configure multiple
    | sources which represent each model / table. These sources may then
    | be assigned to any extra authentication guards you have defined.
    |
    | Supported: "database", "eloquent"
    |
    */

    'providers' => [
        'users' => [
            'driver' => 'eloquent',
            'model' => App\Models\User::class,
        ],

        // 'users' => [
        //     'driver' => 'database',
        //     'table' => 'users',
        // ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Resetting Passwords
    |--------------------------------------------------------------------------
    |
    | You may specify multiple password reset configurations if you have more
    | than one user table or model in the application and you want to have
    | separate password reset settings based on the specific user types.
    |
    | The expiry time is the number of minutes that each reset token will be
    | considered valid. This security feature keeps tokens short-lived so
    | they have less time to be guessed. You may change this as needed.
    |
    | The throttle setting is the number of seconds a user must wait before
    | generating more password reset tokens. This prevents the user from
    | quickly generating a very large amount of password reset tokens.
    |
    */

    'passwords' => [
        'users' => [
            'provider' => 'users',
            'table' => 'password_reset_tokens',
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Confirmation Timeout
    |--------------------------------------------------------------------------
    |
    | Here you may define the amount of seconds before a password confirmation
    | times out and the user is prompted to re-enter their password via the
    | confirmation screen. By default, the timeout lasts for three hours.
    |
    */

    'password_timeout' => 10800,

];
//database.php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Database Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the database connections below you wish
    | to use as your default connection for all database work. Of course
    | you may use many connections at once using the Database library.
    |
    */

    'default' => env('DB_CONNECTION', 'mysql'),

    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the database connections setup for your application.
    | Of course, examples of configuring each database platform that is
    | supported by Laravel is shown below to make development simple.
    |
    |
    | All database work in Laravel is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    |
    */

    'connections' => [

        'sqlite' => [
            'driver' => 'sqlite',
            'url' => env('DATABASE_URL'),
            'database' => env('DB_DATABASE', database_path('database.sqlite')),
            'prefix' => '',
            'foreign_key_constraints' => env('DB_FOREIGN_KEYS', true),
        ],

        'mysql' => [
            'driver' => 'mysql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '3306'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
            'prefix' => '',
            'prefix_indexes' => true,
            'strict' => true,
            'engine' => null,
            'options' => extension_loaded('pdo_mysql') ? array_filter([
                PDO::MYSQL_ATTR_SSL_CA => env('MYSQL_ATTR_SSL_CA'),
            ]) : [],
        ],

        'pgsql' => [
            'driver' => 'pgsql',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', '5432'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            'search_path' => 'public',
            'sslmode' => 'prefer',
        ],

        'sqlsrv' => [
            'driver' => 'sqlsrv',
            'url' => env('DATABASE_URL'),
            'host' => env('DB_HOST', 'localhost'),
            'port' => env('DB_PORT', '1433'),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'forge'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8',
            'prefix' => '',
            'prefix_indexes' => true,
            // 'encrypt' => env('DB_ENCRYPT', 'yes'),
            // 'trust_server_certificate' => env('DB_TRUST_SERVER_CERTIFICATE', 'false'),
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Migration Repository Table
    |--------------------------------------------------------------------------
    |
    | This table keeps track of all the migrations that have already run for
    | your application. Using this information, we can determine which of
    | the migrations on disk haven't actually been run in the database.
    |
    */

    'migrations' => 'migrations',

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Redis is an open source, fast, and advanced key-value store that also
    | provides a richer body of commands than a typical key-value system
    | such as APC or Memcached. Laravel makes it easy to dig right in.
    |
    */

    'redis' => [

        'client' => env('REDIS_CLIENT', 'phpredis'),

        'options' => [
            'cluster' => env('REDIS_CLUSTER', 'redis'),
            'prefix' => env('REDIS_PREFIX', Str::slug(env('APP_NAME', 'laravel'), '_').'_database_'),
        ],

        'default' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_DB', '0'),
        ],

        'cache' => [
            'url' => env('REDIS_URL'),
            'host' => env('REDIS_HOST', '127.0.0.1'),
            'username' => env('REDIS_USERNAME'),
            'password' => env('REDIS_PASSWORD'),
            'port' => env('REDIS_PORT', '6379'),
            'database' => env('REDIS_CACHE_DB', '1'),
        ],

    ],

];
//filesystems.php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been set up for each driver as an example of the required values.
    |
    | Supported Drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
            'throw' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
            'throw' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
//hashing.php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Hash Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default hash driver that will be used to hash
    | passwords for your application. By default, the bcrypt algorithm is
    | used; however, you remain free to modify this option if you wish.
    |
    | Supported: "bcrypt", "argon", "argon2id"
    |
    */

    'driver' => 'bcrypt',

    /*
    |--------------------------------------------------------------------------
    | Bcrypt Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options that should be used when
    | passwords are hashed using the Bcrypt algorithm. This will allow you
    | to control the amount of time it takes to hash the given password.
    |
    */

    'bcrypt' => [
        'rounds' => env('BCRYPT_ROUNDS', 10),
    ],

    /*
    |--------------------------------------------------------------------------
    | Argon Options
    |--------------------------------------------------------------------------
    |
    | Here you may specify the configuration options that should be used when
    | passwords are hashed using the Argon algorithm. These will allow you
    | to control the amount of time it takes to hash the given password.
    |
    */

    'argon' => [
        'memory' => 65536,
        'threads' => 1,
        'time' => 4,
    ],

];

//queue.php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Queue Connection Name
    |--------------------------------------------------------------------------
    |
    | Laravel's queue API supports an assortment of back-ends via a single
    | API, giving you convenient access to each back-end using the same
    | syntax for every one. Here you may define a default connection.
    |
    */

    'default' => env('QUEUE_CONNECTION', 'sync'),

    /*
    |--------------------------------------------------------------------------
    | Queue Connections
    |--------------------------------------------------------------------------
    |
    | Here you may configure the connection information for each server that
    | is used by your application. A default configuration has been added
    | for each back-end shipped with Laravel. You are free to add more.
    |
    | Drivers: "sync", "database", "beanstalkd", "sqs", "redis", "null"
    |
    */

    'connections' => [

        'sync' => [
            'driver' => 'sync',
        ],

        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
            'after_commit' => false,
        ],

        'beanstalkd' => [
            'driver' => 'beanstalkd',
            'host' => 'localhost',
            'queue' => 'default',
            'retry_after' => 90,
            'block_for' => 0,
            'after_commit' => false,
        ],

        'sqs' => [
            'driver' => 'sqs',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'prefix' => env('SQS_PREFIX', 'https://sqs.us-east-1.amazonaws.com/your-account-id'),
            'queue' => env('SQS_QUEUE', 'default'),
            'suffix' => env('SQS_SUFFIX'),
            'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
            'after_commit' => false,
        ],

        'redis' => [
            'driver' => 'redis',
            'connection' => 'default',
            'queue' => env('REDIS_QUEUE', 'default'),
            'retry_after' => 90,
            'block_for' => null,
            'after_commit' => false,
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | Failed Queue Jobs
    |--------------------------------------------------------------------------
    |
    | These options configure the behavior of failed queue job logging so you
    | can control which database and table are used to store the jobs that
    | have failed. You may change them to any database / table you wish.
    |
    */

    'failed' => [
        'driver' => env('QUEUE_FAILED_DRIVER', 'database-uuids'),
        'database' => env('DB_CONNECTION', 'mysql'),
        'table' => 'failed_jobs',
    ],

];

//session.php
return [

    /*
    |--------------------------------------------------------------------------
    | Default Session Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default session "driver" that will be used on
    | requests. By default, we will use the lightweight native driver but
    | you may specify any of the other wonderful drivers provided here.
    |
    | Supported: "file", "cookie", "database", "apc",
    |            "memcached", "redis", "dynamodb", "array"
    |
    */

    'driver' => env('SESSION_DRIVER', 'file'),

    /*
    |--------------------------------------------------------------------------
    | Session Lifetime
    |--------------------------------------------------------------------------
    |
    | Here you may specify the number of minutes that you wish the session
    | to be allowed to remain idle before it expires. If you want them
    | to immediately expire on the browser closing, set that option.
    |
    */

    'lifetime' => env('SESSION_LIFETIME', 120),

    'expire_on_close' => false,

    /*
    |--------------------------------------------------------------------------
    | Session Encryption
    |--------------------------------------------------------------------------
    |
    | This option allows you to easily specify that all of your session data
    | should be encrypted before it is stored. All encryption will be run
    | automatically by Laravel and you can use the Session like normal.
    |
    */

    'encrypt' => false,

    /*
    |--------------------------------------------------------------------------
    | Session File Location
    |--------------------------------------------------------------------------
    |
    | When using the native session driver, we need a location where session
    | files may be stored. A default has been set for you but a different
    | location may be specified. This is only needed for file sessions.
    |
    */

    'files' => storage_path('framework/sessions'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Connection
    |--------------------------------------------------------------------------
    |
    | When using the "database" or "redis" session drivers, you may specify a
    | connection that should be used to manage these sessions. This should
    | correspond to a connection in your database configuration options.
    |
    */

    'connection' => env('SESSION_CONNECTION'),

    /*
    |--------------------------------------------------------------------------
    | Session Database Table
    |--------------------------------------------------------------------------
    |
    | When using the "database" session driver, you may specify the table we
    | should use to manage the sessions. Of course, a sensible default is
    | provided for you; however, you are free to change this as needed.
    |
    */

    'table' => 'sessions',

    /*
    |--------------------------------------------------------------------------
    | Session Cache Store
    |--------------------------------------------------------------------------
    |
    | While using one of the framework's cache driven session backends you may
    | list a cache store that should be used for these sessions. This value
    | must match with one of the application's configured cache "stores".
    |
    | Affects: "apc", "dynamodb", "memcached", "redis"
    |
    */

    'store' => env('SESSION_STORE'),

    /*
    |--------------------------------------------------------------------------
    | Session Sweeping Lottery
    |--------------------------------------------------------------------------
    |
    | Some session drivers must manually sweep their storage location to get
    | rid of old sessions from storage. Here are the chances that it will
    | happen on a given request. By default, the odds are 2 out of 100.
    |
    */

    'lottery' => [2, 100],

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Name
    |--------------------------------------------------------------------------
    |
    | Here you may change the name of the cookie used to identify a session
    | instance by ID. The name specified here will get used every time a
    | new session cookie is created by the framework for every driver.
    |
    */

    'cookie' => env(
        'SESSION_COOKIE',
        Str::slug(env('APP_NAME', 'laravel'), '_') . '_session'
    ),

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Path
    |--------------------------------------------------------------------------
    |
    | The session cookie path determines the path for which the cookie will
    | be regarded as available. Typically, this will be the root path of
    | your application but you are free to change this when necessary.
    |
    */

    'path' => '/',

    /*
    |--------------------------------------------------------------------------
    | Session Cookie Domain
    |--------------------------------------------------------------------------
    |
    | Here you may change the domain of the cookie used to identify a session
    | in your application. This will determine which domains the cookie is
    | available to in your application. A sensible default has been set.
    |
    */

    'domain' => env('SESSION_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | HTTPS Only Cookies
    |--------------------------------------------------------------------------
    |
    | By setting this option to true, session cookies will only be sent back
    | to the server if the browser has a HTTPS connection. This will keep
    | the cookie from being sent to you when it can't be done securely.
    |
    */

    'secure' => env('SESSION_SECURE_COOKIE'),

    /*
    |--------------------------------------------------------------------------
    | HTTP Access Only
    |--------------------------------------------------------------------------
    |
    | Setting this value to true will prevent JavaScript from accessing the
    | value of the cookie and the cookie will only be accessible through
    | the HTTP protocol. You are free to modify this option if needed.
    |
    */

    'http_only' => true,

    /*
    |--------------------------------------------------------------------------
    | Same-Site Cookies
    |--------------------------------------------------------------------------
    |
    | This option determines how your cookies behave when cross-site requests
    | take place, and can be used to mitigate CSRF attacks. By default, we
    | will set this value to "lax" since this is a secure default value.
    |
    | Supported: "lax", "strict", "none", null
    |
    */

    'same_site' => 'lax',

];
//database
//factories
//UserFactory.php
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
//migrations

//1970_01_01_010000_create_teachers_table.php
Schema::create('teachers', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->string('firstname');
    $table->string('lastname');
    $table->string('name')->unique();
    $table->string('short');
    $table->timestamps();
});

//1970_01_01_020000_create_periods_table.php
Schema::create('periods', function (Blueprint $table) {
    $table->string('name')->unique();
    $table->string('short')->unique();
    $table->string('period')->primary();
    $table->string('starttime');
    $table->string('stoptime');
    $table->timestamps();
});
//1970_01_01_040000_create_terms_table.php
Schema::create('terms', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->string('name')->unique();
    $table->string('short')->unique();
    $table->string('terms')->unique();
    $table->timestamps();
});
//1970_01_01_050000_create_weeks_table.php
Schema::create('weeks', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->string('name')->unique();
    $table->string('short')->unique();
    $table->string('weeks')->unique();
    $table->timestamps();
});
//1970_01_01_060000_create_days_table.php
Schema::create('days', function (Blueprint $table) {
    $table->string('id')->unique();
    $table->string('name')->unique();
    $table->string('short')->unique();
    $table->string('day')->primary();
    $table->timestamps();
});
//1970_01_01_070000_create_classrooms_table.php
Schema::create('classrooms', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->string('name')->unique();
    $table->string('short')->unique();
    $table->string('partner_id')->nullable();
    $table->timestamps();
});
//1970_01_01_080000_create_classes_table.php
Schema::create('classes', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->string('name')->unique();
    $table->string('short');
    $table->string('partner_id')->nullable();
    $table->timestamps();
});
//1970_01_01_090000_create_subjects_table.php
Schema::create('subjects', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->string('name')->unique();
    $table->string('short');
    $table->string('partner_id')->nullable();
    $table->timestamps();
});
//1970_01_01_100000_create_groups_table.php
Schema::create('groups', function (Blueprint $table) {
    $table->string('id')->primary();
    $table->string('name');
    $table->string('classid');
    $table->string('entireclass');
    $table->integer('divisiontag');
    $table->foreign('classid')->references('id')->on('classes')->onDelete('cascade');
    $table->timestamps();
});
//1970_01_01_110000_create_lessons_table.php
Schema::create('lessons', function (Blueprint $table) {
    $table->string('id')->primary()->nullable();
    $table->text('classids');
    $table->string('subjectid');
    $table->string('periodspercard');
    $table->string('periodsperweek');
    $table->string('teacherid');
    $table->text('groupids');
    $table->string('termsdefid')->nullable();
    $table->string('weeksdefid');
    $table->string('daysid');
    $table->timestamps();

    //$table->foreign('classids')->references('id')->on('classes')->onDelete('cascade');
    $table->foreign('subjectid')->references('id')->on('subjects')->onDelete('cascade');
    $table->foreign('teacherid')->references('id')->on('teachers')->onDelete('cascade');
    //$table->foreign('groupids')->references('id')->on('groups')->onDelete('cascade');
    $table->foreign('termsdefid')->references('id')->on('terms')->onDelete('cascade');
    $table->foreign('weeksdefid')->references('id')->on('weeks')->onDelete('cascade');
    $table->foreign('daysid')->references('id')->on('days')->onDelete('cascade');

});
//1970_01_01_120000_create_cards_table.php
Schema::create('cards', function (Blueprint $table) {
    $table->id();
    $table->string('lessonid');
    $table->string('classroomids')->nullable();
    $table->string('period');
    $table->string('weeks');
    $table->string('terms');
    $table->string('days');

    $table->foreign('days')->references('day')->on('days')->onDelete('cascade');
    $table->foreign('weeks')->references('weeks')->on('weeks')->onDelete('cascade');
    $table->foreign('terms')->references('terms')->on('terms')->onDelete('cascade');
    $table->foreign('period')->references('period')->on('periods')->onDelete('cascade');
    $table->foreign('lessonid')->references('id')->on('lessons')->onDelete('cascade');
    $table->foreign('classroomids')->references('id')->on('classrooms')->onDelete('cascade');
    $table->timestamps();
});
//1970_01_01_130000_create_users_table.php
Schema::create('users', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->rememberToken();
    $table->timestamps();
});
//seeders
//AdminSeeder.php
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::create([
            'name'=>'admin',
            'email'=>'admin@something.com',
            'email_verified_at'=>now(),
            'password'=>Hash::make('password')
        ]);
    }
}

//DatabaseSeeder.php
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(\Database\Seeders\Time::class);
    }
}
//Time.php
class Time extends Seeder
{
    /**
     * Run database seeding
     */

    public function run(): void
    {
        $xml = simplexml_load_string(file_get_contents('C:\licenta\something\asctt2012 sem 2 2024.xml'));

        //Teachers
        foreach ($xml->teachers->teacher as $teacher) {
            \App\Models\Teacher::create([
                'id' => (string)$teacher['id'],
                'firstname' => (string)$teacher['firstname'],
                'lastname' => (string)$teacher['lastname'],
                'name' => (string)$teacher['name'],
                'short' => (string)$teacher['short'],
            ]);
        }
        //Periods
        foreach ($xml->periods->period as $period) {
            \App\Models\Period::create([
                'name' => (string)$period['name'],
                'short' => (string)$period['short'],
                'period' => (string)$period['period'],
                'starttime' => (string)$period['starttime'],
                'stoptime' => (string)$period['stoptime'],
            ]);
        }
        //Grades
        foreach ($xml->grades->grade as $grade) {
            Grade::create([
                'name' => (string)$grade['name'],
                'short' => (string)$grade['short'],
                'grade' => (string)$grade['grade'],
            ]);
        }
        //Terms
        foreach ($xml->termsdefs->termsdef as $term) {
            \App\Models\Term::create([
                'id' => (string)$term['id'],
                'name' => (string)$term['name'],
                'short' => (string)$term['short'],
                'terms' => (string)$term['terms'],
            ]);
        }
        //Days
        foreach ($xml->daysdefs->daysdef as $daysdef) {
            \App\Models\Day::create([
                'id' => (string)$daysdef['id'],
                'name' => (string)$daysdef['name'],
                'short' => (string)$daysdef['short'],
                'day' => (string)$daysdef['days'],
            ]);
        }
        //Weeks
        foreach ($xml->weeksdefs->weeksdef as $weeksdef) {
            \App\Models\Week::create([
                'id' => (string)$weeksdef['id'],
                'name' => (string)$weeksdef['name'],
                'short' => (string)$weeksdef['short'],
                'weeks' => (string)$weeksdef['weeks'],
            ]);
        }
        //Classrooms
        foreach ($xml->classrooms->classroom as $classroom) {
            \App\Models\Classroom::create([
                'id' => (string)$classroom['id'],
                'name' => (string)$classroom['name'],
                'short' => (string)$classroom['short'],
                'partner_id' => (string)$classroom['partner_id'],
            ]);
        }
        //Classes
        foreach ($xml->classes->class as $class) {
            \App\Models\Clas::create([
                'id' => (string)$class['id'],
                'name' => (string)$class['name'],
                'short' => (string)$class['short'],
                'partner_id' => (string)$class['partner_id'],
            ]);
        }
        //Subjects
        foreach ($xml->subjects->subject as $subject) {
            \App\Models\Subject::create([
                'id' => (string)$subject['id'],
                'name' => (string)$subject['name'],
                'short' => (string)$subject['short'],
                'partner_id' => (string)$subject['partner_id'],
            ]);
        }
        //Groups
        foreach ($xml->groups->group as $group) {
            \App\Models\Group::create([
                'id' => (string)$group['id'],
                'name' => (string)$group['name'],
                'classid' => (string)$group['classid'],
                'entireclass' => (string)$group['entireclass'],
                'divisiontag' => (string)$group['divisiontag'],
            ]);
        }
        //Lessons
        foreach ($xml->lessons->lesson as $lesson) {
            $classids = explode(',', (string)$lesson['classids']);
            $groupids = explode(',', (string)$lesson['groupids']);
            \App\Models\Lesson::create([
                'id' => (string)$lesson['id'],
                'classids' => implode(',', $classids),
                'subjectid' => (string)$lesson['subjectid'],
                'periodspercard' => (string)$lesson['periodspercard'],
                'periodsperweek' => (string)$lesson['periodsperweek'],
                'teacherid' => (string)$lesson['teacherids'],
                'groupids' => implode(',', $groupids),
                'weeksdefid' => (string)$lesson['weeksdefid'],
                'daysid' => (string)$lesson['daysdefid'],
            ]);
        }
        //Cards
        foreach ($xml->cards->card as $card) {
            \App\Models\Card::create([
                'lessonid' => (string)$card['lessonid'],
                'classroomids' => (string)$card['classroomids'],
                'period' => (string)$card['period'],
                'weeks' => (string)$card['weeks'],
                'terms' => (string)$card['terms'],
                'days' => (string)$card['days'],
            ]);
        }

    }
}
//routes
//web.php
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/classes', [TimetableController::class, 'showClasses'])->name('classes');
Route::get('/classrooms', [TimetableController::class, 'showClassrooms'])->name('classrooms');
Route::get('/subjects', [TimetableController::class, 'showSubjects'])->name('subjects');
Route::get('/teachers', [TimetableController::class, 'showTeachers'])->name('teachers');
Route::get('/lessons', [TimetableController::class, 'showLessons'])->name('lessons');
Route::get('/cards', [TimetableController::class, 'showCards'])->name('cards');
Route::get('/test',[TimetableController::class,'test'])->name('test');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [DashboardController::class,'listTables'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/seed-database', [DashboardController::class, 'seedDatabase'])->name('seedDatabase');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
//views
//auth
//components
//layouts
//old_views
//profile
//cards.blade.php
@php
    use App\Models\Clas;
@endphp
<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Orar</h1>
        <div class="mt-4" hidden>
            <label for="card-select" class="block mt-4 text-sm font-medium text-gray-700">Selecteaza o intrare</label>
            <select name="card" id="card-select" disabled
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Selecteaza o intrare</option>
            </select>
        </div>

        <div class="mt-4">
            <label for="search" class="block text-sm font-medium text-gray-700">Cauta:</label>
            <input type="text" id="search" name="search"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <div class="mt-4">
            <x-back-button
                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"/>
        </div>

        <div>
            <h2 class="text-lg font-semibold mb-2">Materii</h2>
            <div class="relative">
                <select onchange="filterTable(this.value)"
                        class="block w-full py-2 px-4 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" selected>Selecteaza o materie</option>
@foreach($cards->unique('lesson.subject.name') as $card)
                        <option value="{{ $card->lesson->subject->name }}">{{ $card->lesson->subject->name }}</option>
@endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>

        <div>
            <h2 class="text-lg font-semibold my-2">Cadre didactice</h2>
            <div class="relative">
                <select onchange="filterTable(this.value)"
                        class="block w-full py-2 px-4 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" selected>Selecteaza un cadru didactic</option>
@foreach($cards->unique('lesson.teacher.name') as $card)
                        <option
                                value="{{ ltrim($card->lesson->teacher->name, "_") }}">{{ ltrim($card->lesson->teacher->name, "_") }}</option>
@endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>


        <div>
            <h2 class="text-lg font-semibold my-2">Sali de curs</h2>
            <div class="relative">
                <select onchange="filterTable(this.value)"
                        class="block w-full py-2 px-4 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    <option value="" selected>Selecteaza o sala de curs</option>
@foreach($cards->unique('classroom.name') as $card)
                        <option value="{{ $card->classroom->name }}">{{ $card->classroom->name }}</option>
@endforeach
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            </div>
        </div>


        {{--        <div>--}}
        {{--            <h2 class="text-lg font-semibold my-2">Grupe</h2>--}}
        {{--            <div class="relative">--}}
        {{--                <select onchange="filterTable(this.value)" class="block w-full py-2 px-4 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">--}}
        {{--                    <option value="" selected>Selecteaza o grupa</option>--}}
        {{--                    @foreach($classes as $class)--}}
        {{--                        <option value="{{ $class->name }}">{{ $class->name }}</option>--}}
        {{--                    @endforeach--}}
        {{--                </select>--}}
        {{--                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">--}}
        {{--                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
        {{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>--}}
        {{--                    </svg>--}}
        {{--                </div>--}}
        {{--            </div>--}}
    </div>


    <div class="mt-4">
        <div class="w-full flex justify-center">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
Curs
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
Profesor
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
Semigrupa
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
Sala
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
Ora
                    </th>
                    <th scope="col"
                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
Ziua
                    </th>
                </tr>
                </thead>
                <tbody id="selected-data">
    @foreach($cards->sortBy('lesson.days') as $index => $card)
    @php
                        $lesson = $card->lesson;//curs

                        $subject = $lesson->subject->name ?? 'No Subject';//curs -> materie

                        $teacher = ltrim($lesson->teacher->name, '_') ?? 'No Teacher';//curs -> nume profesor

                        // Fetching class names for each class ID
                        $classIds = explode(',', $lesson->classids);
                        $classNames = [];
                        $prefixes = []; // To store unique prefixes

                        foreach ($classIds as $classId) {
                            $class = Clas::find($classId);
                            if ($class) {
                                // Extract the prefix before the slash
                                $prefix = strtok($class->name, '/');

                                // Store unique prefixes
                                if (!isset($prefixes[$prefix])) {
                                    $prefixes[$prefix] = [];
                                }

                                $prefixes[$prefix][] = $class->name;
                            }
                        }

                        $class = '';
                        foreach ($prefixes as $prefix => $classes) {
                            if (count($classes) > 1) {
                                // If there are multiple classes with the same prefix, clump them together
                                $class .= $prefix . ', ';
                            } else {
                                // Otherwise, include the individual class
                                $class .= implode(', ', $classes) . ', ';
                            }
                        }

                        $class = rtrim($class, ', '); // Remove trailing comma and space

                        $classroom = $card->classroom->short ?? 'No Classroom';//sala

                        $period = $card->period ?? 'No Period';//ora

                        $dayMapping = [
                            '00001' => 'Luni',
                            '00010' => 'Marti',
                            '00100' => 'Miercuri',
                            '01000' => 'Joi',
                            '10000' => 'Vineri',
                        ];
                        $day = $dayMapping[$card->days] ?? 'No Day';//ziua

                        $periodMapping = [
                            '1' => '08:00 - 08:50',
                            '2' => '09:00 - 09:50',
                            '3' => '10:00 - 10:50',
                            '4' => '11:00 - 11:50',
                            '5' => '12:00 - 12:50',
                            '6' => '13:00 - 13:50',
                            '7' => '14:00 - 14:50',
                            '8' => '15:00 - 15:50',
                            '9' => '16:00 - 16:50',
                            '10' => '17:00 - 17:50',
                            '11' => '18:00 - 18:50',
                            '12' => '19:00 - 19:50',
                            '13' => '20:00 - 20:50',
                            '14' => '21:00 - 21:50',
                        ];

                        // Determine the prefix based on the condition
        $prefix = strpos($class, '/') === false ? 'CURS' : 'LAB';
        $subject = $prefix . ' ' . ($lesson->subject->name ?? 'No Subject');

                        $period = $periodMapping[$card->period] ?? 'No Period';
                    @endphp
                    <tr class="bg-white">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $subject }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $teacher }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $class }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $classroom }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $period }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $day }}
                        </td>
                    </tr>
@endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const rows = document.querySelectorAll('#selected-data tr');

    searchInput.addEventListener('input', function () {
        const searchTerms = this.value.trim().toLowerCase().split(/\s+/);

                rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            let found = false;

                    cells.forEach(cell => {
                const textContent = cell.textContent.trim().toLowerCase();
                if (searchTerms.every(term => textContent.includes(term))) {
                    found = true;
                }
                    });

                    if (found) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
});

        function filterTable(value) {
            const searchInput = document.getElementById('search');
            searchInput.value = value;
            searchInput.dispatchEvent(new Event('input'));
        }
    </script>

</x-app-layout>

//classes.blade.php
@php
    use App\Models\Clas;
@endphp
<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Orar</h1>
        <div class="mt-4" hidden>
            <label for="card-select" class="block mt-4 text-sm font-medium text-gray-700">Selecteaza o intrare</label>
            <select name="card" id="card-select" disabled
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Selecteaza o intrare</option>
            </select>
        </div>

        <div class="mt-4">
            <label for="search" class="block text-sm font-medium text-gray-700">Cauta:</label>
            <input type="text" id="search" name="search"
                   class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
        </div>

        <x-back-button
            class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"/>

        <div class="mt-4">
            <div class="w-full flex justify-center">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
Curs
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
Profesor
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
Semigrupa
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
Sala
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
Ora
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
Ziua
                        </th>
                    </tr>
                    </thead>
                    <tbody id="selected-data">
    @foreach($cards->sortBy('lesson.days') as $index => $card)
    @php
                            $lesson = $card->lesson;//curs

                            $subject = $lesson->subject->name ?? 'No Subject';//curs -> materie

                            $teacher = ltrim($lesson->teacher->name, '_') ?? 'No Teacher';//curs -> nume profesor

                            // Fetching class names for each class ID
                            $classIds = explode(',', $lesson->classids);
                            $classNames = [];
                            $prefixes = []; // To store unique prefixes

                            foreach ($classIds as $classId) {
                                $class = Clas::find($classId);
                                if ($class) {
                                    // Extract the prefix before the slash
                                    $prefix = strtok($class->name, '/');

                                    // Store unique prefixes
                                    if (!isset($prefixes[$prefix])) {
                                        $prefixes[$prefix] = [];
                                    }

                                    $prefixes[$prefix][] = $class->name;
                                }
                            }

                            $class = '';
                            foreach ($prefixes as $prefix => $classes) {
                                if (count($classes) > 1) {
                                    // If there are multiple classes with the same prefix, clump them together
                                    $class .= $prefix . ', ';
                                } else {
                                    // Otherwise, include the individual class
                                    $class .= implode(', ', $classes) . ', ';
                                }
                            }

                            $class = rtrim($class, ', '); // Remove trailing comma and space


                            $classroom = $card->classroom->short ?? 'No Classroom';//sala

                            $period = $card->period ?? 'No Period';//ora

                            $dayMapping = [
                                '00001' => 'Luni',
                                '00010' => 'Marti',
                                '00100' => 'Miercuri',
                                '01000' => 'Joi',
                                '10000' => 'Vineri',
                            ];
                            $day = $dayMapping[$card->days] ?? 'No Day';//ziua

                            $periodMapping = [
                                '1' => '08:00 - 08:50',
                                '2' => '09:00 - 09:50',
                                '3' => '10:00 - 10:50',
                                '4' => '11:00 - 11:50',
                                '5' => '12:00 - 12:50',
                                '6' => '13:00 - 13:50',
                                '7' => '14:00 - 14:50',
                                '8' => '15:00 - 15:50',
                                '9' => '16:00 - 16:50',
                                '10' => '17:00 - 17:50',
                                '11' => '18:00 - 18:50',
                                '12' => '19:00 - 19:50',
                                '13' => '20:00 - 20:50',
                                '14' => '21:00 - 21:50',
                            ];

                            $period = $periodMapping[$card->period] ?? 'No Period';
                        @endphp
                        <tr class="bg-white">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $subject }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $teacher }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $class }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $classroom }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $period }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $day }}
                            </td>
                        </tr>
@endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('search');
    const rows = document.querySelectorAll('#selected-data tr');

    searchInput.addEventListener('input', function () {
        const searchTerms = this.value.trim().toLowerCase().split(/\s+/);

                rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            let found = false;

                    cells.forEach(cell => {
                const textContent = cell.textContent.trim().toLowerCase();
                if (searchTerms.every(term => textContent.includes(term))) {
                    found = true;
                }
                    });

                    if (found) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
});
    </script>

</x-app-layout>

//classrooms.blade.php
<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Sali</h1>

        <div class="mt-4">
            <label for="classroom-select" class="block text-sm font-medium text-gray-700">Selecteaza o sala</label>
            <select name="classroom" id="classroom-select"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Selecteaza o sala</option>
@foreach($classrooms->sortBy('name') as $index => $classroom)
                    <option value="{{ $classroom['id'] }}">{{ $classroom['short'] }}</option>
@endforeach
            </select>
        </div>

        <div class="mt-4">
            <x-back-button
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"/>
        </div>

        <div id="group-header" class="mt-6 text-center" style="display:none;">
            <h3 class="text-lg leading-6 font-medium text-gray-900"><span id="selected-classroom"
                                                                          class="text-indigo-600">N/A</span></h3>
            <!-- Schedule Table Placeholder -->
            <div id="schedule-table" class="mt-4">
                <!-- Dynamically generated schedule will be inserted here -->
            </div>
        </div>
    </div>

    <script>
        const select = document.getElementById('classroom-select');
        const selectedClassroom = document.getElementById('selected-classroom');
        const scheduleTable = document.getElementById('schedule-table');

        select.addEventListener('change', function () {
            const selectedIndex = select.selectedIndex;
            const selectedOption = select.options[selectedIndex];
            const groupHeader = document.getElementById('group-header');

            if (selectedOption.value) {
                selectedClassroom.textContent = selectedOption.text;
                groupHeader.style.display = '';
            } else {
                groupHeader.style.display = 'none';
            }

            updateScheduleTable(selectedOption.value);
        });

        // Display the selected option text
        if (select.selectedIndex >= 0) {
            selectedClassroom.textContent = select.options[select.selectedIndex].text;
        }

        function updateScheduleTable(classId) {
            // Define the start and end hours
            const startHour = 8; // Starting at 8
            const endHour = 21; // Up to 21, for 21-22 slot

            // Start building the table HTML
            let tableHTML = `
            <table class="min-w-full divide-y divide-gray-200 border border-black-900">
                <thead>
                    <tr>
                        @foreach($headers as $header)
            <th class="text-center px-6 py-3 bg-gray-50 text-left text-xs font-small text-gray-500 border border-black-900 uppercase tracking-wider">{{ $header }}</th>
                      @endforeach
            </tr>
        </thead>

        <tbody>`;

            // Loop from startHour to endHour and generate table rows
            for (let hour = startHour; hour <= endHour; hour++) {
                // Format the time slot string
                let timeSlot = `${hour}-${hour+1}`;

                // Generate the row with dynamic time slots
                tableHTML += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap border border-black-900">${timeSlot}</td>
                            @foreach($contents as $content)
                <th class="text-center px-6 py-3 bg-gray-50 text-left text-xs font-small text-gray-500 border border-black-900 lowercase tracking-wider">{{ $content }}</th>
                            @endforeach
                </tr>`;
            }

            // Close the table HTML
            tableHTML += `
                </tbody>
            </table>`;

            // Update the scheduleTable's innerHTML with the generated table HTML
            scheduleTable.innerHTML = tableHTML;
        }

    </script>

</x-app-layout>

//dashboard.blade.php
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Panou de control') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-12">
        <div class="flex justify-end p-6">
            <form action="{{ route('seedDatabase') }}" method="POST">
    @csrf
                @php
                    $disableButton = collect($tableCounts)->contains(function ($count) {
                        return $count > 16;
                    });
                    $seeded = $seedingStatus->seeded ?? false; // Assuming $seedingStatus is fetched from the database or cache
                @endphp
                <button id="seedButton" type="submit" class="bg-{{ $seeded ? 'green' : 'blue' }}-500 hover:bg-{{ $seeded ? 'green' : 'blue' }}-700 text-white font-bold py-2 px-4 rounded" {{ $disableButton ? 'disabled' : '' }}>
                    {{ $seeded ? 'Database Seeded' : 'Seed Database' }}
                </button>
            </form>
        </div>



        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6">
                <table class="min-w-full">
                    <thead class="border-b">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
Baza de date
</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
Număr de intrări
</th>
                    </tr>
                    </thead>
                    <tbody>
@foreach($tables as $table)
                        <tr class="border-b">
                            <td class="text-sm text-gray-900 dark:text-gray-100 px-6 py-4 whitespace-nowrap">
                                {{ $table }}
                            </td>
                            <td class="text-sm text-gray-900 dark:text-gray-100 px-6 py-4 whitespace-nowrap">
                                {{ $tableCounts[$table] }}
                            </td>
                        </tr>
@endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
//home.blade.php
<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-5">
{{--                <x-classes-button />--}}
                <x-classrooms-button />
                <x-lessons-button />
                <x-subjects-button />
                <x-teachers-button />
                <x-cards-test />
            </div>
        </div>
    </div>
</x-app-layout>

//layout.blade.php
<!DOCTYPE html>
<html>
<head>
    <title>@yield('title')</title>
</head>
<body>
@yield('content')
    </body>
</html>

//lessons.blade.php
@php use App\Models\Day;use App\Models\Clas;use App\Models\Subject;use App\Models\Teacher; @endphp
<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Cursuri</h1>

        <div class="mt-4">
            <label for="lesson-select" class="block text-sm font-medium text-gray-700">Selecteaza un curs</label>
            <select name="lesson" id="lesson-select"
                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Selecteaza un curs</option>
@foreach($lessons as $index => $lesson)
    @php
                        $subject = Subject::find($lesson['subjectid']);
                        $subjectName = $subject ? $subject->name : 'N/A';

                        $teacher = Teacher::find($lesson['teacherid']);
                        $teacherName = $teacher ? str_replace('_', ' ', $teacher->name) : 'N/A';

                        $classids = explode(',', $lesson['classids']);
                        $classNames = [];
                        foreach ($classids as $classid) {
                            $class = Clas::find($classid);
                            $classNames[] = $class ? $class->name : 'N/A';
                        }
                        $classNamesString = implode(', ', $classNames);
                        $daysdef = Day::find($lesson['daysid']);
                        $day = $daysdef ? $daysdef -> name : 'N/A';
                    @endphp

                    @if($classNamesString !== 'N/A')
{{-- Only show options where class name is not N/A --}}
                        <option value="{{$lesson['id']}}"
                                {{$index == -1 ? 'selected' : ''}} data-lesson="{{ $subjectName }}"
                                data-teacher="{{ $teacherName }}" data-class="{{ $classNamesString }}"
                                data-day="{{$day}}">
                            {{ $subjectName }} - {{ $teacherName }} - {{ $classNamesString }} - {{$day}}
                        </option>
@endif
                @endforeach
            </select>
        </div>

        <div class="mt-4">
            <x-back-button
                class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"/>
        </div>

        <div id="group-header" style="display:none;" class="mt-6">
            <h2 class="text-lg leading-6 font-medium text-gray-900">Curs: <span id="selected-lesson"
                                                                                class="text-indigo-600">N/A</span></h2>
            <h2 class="text-lg leading-6 font-medium text-gray-900">Profesor: <span id="selected-teacher"
                                                                                    class="text-indigo-600">N/A</span>
            </h2>
            <h2 class="text-lg leading-6 font-medium text-gray-900">Grupa: <span id="selected-class"
                                                                                 class="text-indigo-600">N/A</span></h2>
            <h2 class="text-lg leading-6 font-medium text-gray-900">Ziua: <span id="selected-day"
                                                                                class="text-indigo-600">N/A</span></h2>
        </div>
    </div>

    <script>
        const select = document.getElementById('lesson-select');
        const selectedLesson = document.getElementById('selected-lesson');
        const selectedTeacher = document.getElementById('selected-teacher');
        const selectedClass = document.getElementById('selected-class');
        const selectedDay = document.getElementById('selected-day');

        select.addEventListener('change', function () {
            const selectedIndex = select.selectedIndex;
            const selectedOption = select.options[selectedIndex];
            const groupHeader = document.getElementById('group-header');

            if (selectedOption.value) {
                selectedLesson.textContent = selectedOption.dataset.lesson || 'N/A';
                selectedTeacher.textContent = selectedOption.dataset.teacher || 'N/A';
                selectedClass.textContent = selectedOption.dataset.class || 'N/A';
                selectedDay.textContent = selectedOption.dataset.day || 'N/A';
                groupHeader.style.display = '';
            } else {
                groupHeader.style.display = 'none';
            }
        });

        // Initialize with the first option's data if available
        if (select.options.length > 1 && select.options[0].dataset) {
            const initialData = select.options[0].dataset;
            selectedLesson.textContent = initialData.lesson || 'N/A';
            selectedTeacher.textContent = initialData.teacher || 'N/A';
            selectedClass.textContent = initialData.class || 'N/A';
            selectedDay.textContent = initialData.day || 'N/A';
        }
    </script>
</x-app-layout>

//periods.blade.php

//subjects.blade.php
<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Materii</h1>

        <div class="mt-4">
            <label for="subject-select" class="block text-sm font-medium text-gray-700">Selecteaza o materie</label>
            <select name="subject" id="subject-select" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Selecteaza o materie</option>
@foreach($subjects->sortBy('name') as $index => $subject)
                    <option value="{{ $subject['id'] }}" {{ $index == -1 ? 'selected' : '' }}>{{ ltrim($subject['name'], '_') }}</option>
@endforeach
            </select>
        </div>

        <div class="mt-4">
            <x-back-button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" />
        </div>

        <div id="group-header" class="mt-6" style="display:none;">
            <h3 class="text-lg leading-6 font-medium text-gray-900"><span id="selected-subject" class="text-indigo-600">N/A</span></h3>
        </div>
    </div>

    <script>
        const select = document.getElementById('subject-select');
        const selectedSubject = document.getElementById('selected-subject');

        select.addEventListener('change', function() {
            const selectedIndex = select.selectedIndex;
            const selectedOption = select.options[selectedIndex];
            const groupHeader = document.getElementById('group-header');

            if (selectedOption.value) {
                selectedSubject.textContent = selectedOption.text;
                groupHeader.style.display = '';
            } else {
                groupHeader.style.display = 'none';
            }
        });

        // Display the selected option text
        if(select.selectedIndex >= 0) {
            selectedSubject.textContent = select.options[select.selectedIndex].text;
        }
    </script>
</x-app-layout>

//teachers.blade.php
<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <h1 class="text-2xl font-semibold text-gray-900">Cadre didactice</h1>

        <div class="mt-4">
            <label for="teacher-select" class="block text-sm font-medium text-gray-700">Selecteaza un cadru didactic</label>
            <select name="teacher" id="teacher-select" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                <option value="" disabled selected>Selecteaza un cadru didactic</option>
@foreach($teachers as $index => $teacher)
                    <option value="{{ $teacher['id'] }}" {{ $index == -1 ? 'selected' : '' }}>{{ ltrim($teacher['name'], '_') }}</option>
@endforeach
            </select>
        </div>

        <div class="mt-4">
            <x-back-button class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" />
        </div>

        <div id="group-header" class="mt-6 text-center" style="display:none;">
            <h3 class="text-lg leading-6 font-medium text-gray-900"><span id="selected-teacher"
                                                                          class="text-indigo-600">N/A</span></h3>
            <!-- Schedule Table Placeholder -->
            <div id="schedule-table" class="mt-4">
                <!-- Dynamically generated schedule will be inserted here -->
            </div>
        </div>
    </div>

    <script>
        const select = document.getElementById('teacher-select');
        const selectedTeacher = document.getElementById('selected-teacher');
        const scheduleTable = document.getElementById('schedule-table');

        select.addEventListener('change', function () {
            const selectedIndex = select.selectedIndex;
            const selectedOption = select.options[selectedIndex];
            const groupHeader = document.getElementById('group-header');

            if (selectedOption.value) {
                selectedTeacher.textContent = selectedOption.text;
                groupHeader.style.display = '';
            } else {
                groupHeader.style.display = 'none';
            }

            updateScheduleTable(selectedOption.value);
        });

        // Display the selected option text
        if(select.selectedIndex >= 0) {
            selectedTeacher.textContent = select.options[select.selectedIndex].text;
        }

        function updateScheduleTable(teacherId) {
            // Define the start and end hours
            const startHour = 8; // Starting at 8
            const endHour = 21; // Up to 21, for 21-22 slot

            // Start building the table HTML
            let tableHTML = `
            <table class="min-w-full divide-y divide-gray-200 border border-black-900">
                <thead>
                    <tr>
                        @foreach($headers as $header)
            <th class="text-center px-6 py-3 bg-gray-50 text-left text-xs font-small text-gray-500 border border-black-900 uppercase tracking-wider">{{ $header }}</th>
                      @endforeach
            </tr>
        </thead>

        <tbody>`;

            // Loop from startHour to endHour and generate table rows
            for (let hour = startHour; hour <= endHour; hour++) {
                // Format the time slot string
                let timeSlot = `${hour}-${hour+1}`;

                // Generate the row with dynamic time slots
                tableHTML += `
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap border border-black-900">${timeSlot}</td>
                            @foreach($contents as $content)
                <th class="text-center px-6 py-3 bg-gray-50 text-left text-xs font-small text-gray-500 border border-black-900 uppercase tracking-wider">{{ $content }}</th>
                            @endforeach
                </tr>`;
            }

            // Close the table HTML
            tableHTML += `
                </tbody>
            </table>`;

            // Update the scheduleTable's innerHTML with the generated table HTML
            scheduleTable.innerHTML = tableHTML;
        }
    </script>
</x-app-layout>

//.env
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:vkGyrxmnNHUUYDt/cWS5/e7VlWGgqvwYUWMqJWHTHiM=
APP_DEBUG=true
APP_URL=http://192.168.1.25:8000

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=something
DB_USERNAME=root
DB_PASSWORD=

BROADCAST_DRIVER=log
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

MEMCACHED_HOST=127.0.0.1

REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="${APP_NAME}"

AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
AWS_USE_PATH_STYLE_ENDPOINT=false

PUSHER_APP_ID=
PUSHER_APP_KEY=
PUSHER_APP_SECRET=
PUSHER_HOST=
PUSHER_PORT=443
PUSHER_SCHEME=https
PUSHER_APP_CLUSTER=mt1

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

//composer.json
{
    "name": "laravel/laravel",
    "type": "project",
    "description": "The Laravel Framework.",
    "keywords": ["framework", "laravel"],
    "license": "MIT",
    "require": {
    "php": "^8.2",
        "guzzlehttp/guzzle": "^7.2",
        "laravel/framework": "^10.0",
        "laravel/sanctum": "^3.2",
        "laravel/tinker": "^2.8",
      "ext-simplexml": "*"
    },
    "require-dev": {
    "fakerphp/faker": "^1.9.1",
        "laravel/breeze": "^1.28",
        "laravel/pint": "^1.0",
        "laravel/sail": "^1.18",
        "mockery/mockery": "^1.4.4",
        "nunomaduro/collision": "^7.0",
        "pestphp/pest": "^2.0",
        "pestphp/pest-plugin-laravel": "^2.0",
        "spatie/laravel-ignition": "^2.0"
    },
    "autoload": {
    "psr-4": {
        "App\\": "app/",
            "Database\\Factories\\": "database/factories/",
            "Database\\Seeders\\": "database/seeders/"
        }
    },
    "autoload-dev": {
    "psr-4": {
        "Tests\\": "tests/"
        }
    },
    "scripts": {
    "post-autoload-dump": [
        "Illuminate\\Foundation\\ComposerScripts::postAutoloadDump",
        "@php artisan package:discover --ansi"
    ],
        "post-update-cmd": [
        "@php artisan vendor:publish --tag=laravel-assets --ansi --force"
    ],
        "post-root-package-install": [
        "@php -r \"file_exists('.env') || copy('.env.example', '.env');\""
    ],
        "post-create-project-cmd": [
        "@php artisan key:generate --ansi"
    ]
    },
    "extra": {
    "laravel": {
        "dont-discover": []
        }
    },
    "config": {
    "optimize-autoloader": true,
        "preferred-install": "dist",
        "sort-packages": true,
        "allow-plugins": {
        "pestphp/pest-plugin": true,
            "php-http/discovery": true
        }
    },
    "minimum-stability": "stable",
    "prefer-stable": true
}

