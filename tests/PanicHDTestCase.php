<?php

namespace PanicHD\PanicHD\Tests;

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Testing\TestCase;
use PanicHD\PanicHD\Controllers\InstallController;
use PanicHD\PanicHD\Models\Member;
use PanicHD\PanicHD\Models\Setting;

abstract class PanicHDTestCase extends TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';
	
	// Cover different test methods for different Laravel Versions
	protected $laravel_version = null;
	
	// Package general status
    protected $status = "Not installed";

    // Main route
    protected $main_route = null;

    // Member types tests set
    protected $member = null, $agent = null, $admin = null;

    // Eloquent reusable builder for Member Tickets
    protected $member_tickets_builder;
	
	/**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $laravel_root = __DIR__ . '/../../../../';
		$app = require $laravel_root . 'bootstrap/app.php';

        $app->make(Kernel::class)->bootstrap();

        return $app;
    }

    /*
     * Load a basic vars set for package tests
    */
    public function load_vars()
    {
        if (is_null($this->main_route)){
            $InstallController = new InstallController();

            if (!$InstallController->isInstalled()){
                if (\Cache::has('panichd::installation')) $this->status = "Installing";

            }elseif (!$InstallController->isUpdated()){
                $this->status = "Out of date";

            }else{
                $this->status = "Installed";

                $this->main_route = Setting::grab('main_route');
            }
        }

        if (is_null($this->member)){
			// TODO: Generate fake user
            if (Member::users()->count() > 0){
                $this->member = Member::whereHas('tickets', function($query){ $query->notHidden(); })->inRandomOrder()->users()->first();
                if (!is_null($this->member)){
                    // TODO: Generate fake tickets
					$this->member_tickets_builder = $this->member->tickets()->inRandomOrder();
                }
            }
        }

        if (is_null($this->agent)){
            // TODO: Generate fake agent
			if (Member::agents()->count() > 0){
                $this->agent = Member::whereHas('agentTickets')->inRandomOrder()->agents()->first();
            }
        }

        if (is_null($this->admin)){
			// TODO: Generate fake admin
            if (Member::admins()->count() > 0){
                $this->admin = Member::inRandomOrder()->admins()->first();
            }
        }
		
		if (is_null($this->laravel_version)){
			$laravel = app();

			$this->laravel_version = $laravel::VERSION;
		}
    }
	
	/*
	 * Execute different assertRedirect deppending on Laravel version
	*/
	public function versionAssertRedirect($response, $url)
	{
		if (version_compare($this->laravel_version, '5.4', '<')){
			$response->assertRedirectedTo($url);
		}else{
			$response->assertRedirect($url);
		}
	}
	
	/*
	 * Execute different assertStatus deppending on Laravel version
	*/
	public function versionAssertStatus($response, $status)
	{
		if (version_compare($this->laravel_version, '5.4', '<')){
			$response->assertResponseStatus($status);
		}else{
			$response->assertStatus($status);
		}
	}
}

?>
