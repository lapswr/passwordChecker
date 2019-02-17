<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Symfony\Component\Yaml\Yaml;

class PasswordChecker extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'password:check
                            {password? : Check a password against the rules}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if the passwords in table are valid or check a password if is valid';

    /**
     *
     *
     * @var Array
     */
    protected $rules  = [];

    /**
     * PasswordChecker constructor.
     */
    public function __construct()
    {
        parent::__construct();
        if (File::exists(base_path('rules.yaml')))
        {
            $this->rules = Yaml::parse(File::get(base_path('rules.yaml')));
        }
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle()
    {
        $passwordInput = $this->argument('password');

        if ($passwordInput)
        {
            $this->info('Password checker will check if the inputted password is valid');

            if ($this->validate($passwordInput))
            {
                $this->info('Password : '.$passwordInput.' Is Valid!');
            }
        }
        else
        {
            $this->info('Password checker will check the if the passwords table are valid');

            DB::table('passwords')->chunkById(100, function ($passwords)
            {
                foreach ($passwords as $row)
                {
                    if ($this->validate($row->password))
                    {
                        DB::table('passwords')->where('id', $row->id)->update(['valid' => 1]);
                        $this->info('Password : '.$row->password.' Is Valid!');
                    }
                }
            });
        }
        return true;
    }

    /**
     * Validate a password against the rules
     *
     * @param $password
     * @return bool
     */
    protected function validate($password = null)
    {
        if($password) {
            foreach ($this->rules as $rule) {
                if (($rule['inverted_match']) ? !preg_match($rule['regex'], $password) : preg_match($rule['regex'], $password)) {
                    $this->error('Password : ' . $password . ' Is Not Valid!');
                    $this->error($rule['error_message']);
                    return false;
                }
            }
            return true;
        }
        return false;
    }
}
