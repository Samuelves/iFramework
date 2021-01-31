<?php

/*
  MIT License

  Copyright (c) 2021 Ives Samuel

  Permission is hereby granted, free of charge, to any person obtaining a copy
  of this software and associated documentation files (the "Software"), to deal
  in the Software without restriction, including without limitation the rights
  to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
  copies of the Software, and to permit persons to whom the Software is
  furnished to do so, subject to the following conditions:

  The above copyright notice and this permission notice shall be included in all
  copies or substantial portions of the Software.

  THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
  IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
  FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
  AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
  LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
  OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
  SOFTWARE.
 */

namespace Core;
use App\Models\User;
/**
 * Description of Authenticate
 *
 * @author Ives Samuel
 */
trait Authenticate
{
    public function login()
    {
        $this->setPageTitle('Login');
        return $this->renderView('user/login', 'layout');
    }

    public function auth($request)
    {
        $result = User::where('email', $request->post->email)->first();

        if($result && password_verify($request->post->password, $result->password)){
            $user = [
                'id' => $result->id,
                'name' => $result->name,
                'email' => $result->email
            ];
            Session::set('user', $user);
            return Redirect::route('/');
        }

        return Redirect::route('/login', [
            'errors' => ['Usuário ou senha estão incorretos'],
            'inputs' => ['email' => $request->post->email]
        ]);
    }

    public function logout()
    {
        Session::destroy('user');
        return Redirect::route('/login');
    }
}
