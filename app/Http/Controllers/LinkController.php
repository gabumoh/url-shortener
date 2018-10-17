<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\URL;
use App\Link;
use Validator;

class LinkController extends Controller
{
    public function index() 
    {
    	// Code to load the default page where the url shortener form is present
    	return view('welcome');
    }

    public function make(Request $request)
    {
    	// Get all input from the present session on the url shortener form and page
        $input = $request->all();

        // Simple implementation of validation for the url shortener form. This validation must pass before the code can be executed.
        $validator = Validator::make($input, [
            'url' => 'required|url|min:20',
        ]);

        // Code to check if the validation failed.
        if ($validator->fails()) {

        	// If validation fails, it redirects back to the previous page and displays the errors.
            return redirect()->back()->withErrors($validator);

        } else { // When validation passes, it executes the codes to shorten the url
            
            $url = Link::whereUrl($request->get('url'))->first();

            if ($url) { // This check is the url entered already exists in our database, if it does it redirects back to the previous page with the shortened url in the database.

                return redirect()->back()->withInput()->with('message', 'Shortened Link Already exists: <a href="'.url("/{$url->code}").'" target="_blank">"'.url("/{$url->code}").'"</a>');

            } else { // If the url does not exist in the database, the process to shorten the url continues.

                do { // This is a simple way of genarating hash codes for the submited url. The hash is then stored in the variable $newHash.

                    $newHash = Str::random(6);

                } while (Link::where('code', '=', $newHash)->count() > 0);

                // We use the eloquent builder to store our values into our database.
                $link = new Link([
                    'url' => $request->get('url'),
                    'code' => $newHash,
                ]);

                $link->save();

                // After shortened url has been created, we display the url to the user.
                return redirect()->back()->withInput()->with('message', 'Here is your shortened url: <a href="'.url("/{$link->code}").'" target="_blank">"'.url("/{$link->code}").'"</a>');
            }

        }
    }

    public function get($code)
    {

    	// We check if the hash supplied to the url exists in the database
        $link = Link::where('code','=',$code)->first();

        if ($link) { // If the hash exists, we get the url associated with the code and redirect the user to the shortened url's original url.

        	return redirect($link->url);

        } else { // If the hash given is invalid we redirect the user to the home page with the error that the link supplied is invalid.

        	return redirect('/')->withErrors('Invalid Link');
        }
    }
}
