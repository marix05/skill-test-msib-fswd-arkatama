<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class RegistrationController extends Controller
{
    public function index () {
        return view('web.registration.index', [
            "title" => "Registration",
            "nav" => [
                "active" => "Registration",
            ],
            "users" => User::all(),
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'input' => ['required', 'string'],
        ]);

        $input = explode(" ", $request->input);

        if (count($input) >= 3) {
            $name = "";
            $age = "";
            $city = "";
            $foundNumber = false;
            foreach ($input as $str) {
                if(!$foundNumber) {
                    // apabila kata bukan merupakan angka, maka itu nama
                    if (preg_match("/\d+/", $str) == false) {
                        $name .= strtoupper($str) . " ";
                    }
                    // apabila kata dimulai dari angka, maka itu umur
                    else if (preg_match("/\d+T?(AHUN|AHU|HN|H)?/i", $str)) {
                        $age = preg_replace("/[^0-9]/", "", $str);
                        $foundNumber = true;
                    }
                }
                // memastikan bahwa kata setelah angka bukan kata tahun, thn, th, dan sejenisnya
                else if (preg_match("/\b(tahun|tahu|thn|ta|th|tn|tun)\b/i", $str) == false) {
                    $city .= strtoupper($str) . " ";
                }
            }

            $name = trim($name);
            $city = trim($city);

            $user = new User([
                'name' => $name,
                'age' => $age,
                'city' => $city,
            ]);

            if ($user->save()) {
                return back()->with('success', 'Input berhasil dilakukan');
            }
        } else {
            return back()->with('error', 'Format Inputan Tidak Sesuai');
        }

        return back()->with('error', 'Input gagal, silahkan untuk mengulang');
    }

    public function update(Request $request) {
        $request->validate([
            'input' => ['required', 'string'],
            'id' => ['required'],
        ]);

        $user = User::findOrFail($request->id);
        if ($user) {
            $input = explode(" ", $request->input);

            if (count($input) >= 3) {
                $name = "";
                $age = "";
                $city = "";
                $foundNumber = false;
                foreach ($input as $str) {
                    if(!$foundNumber) {
                        // apabila kata bukan merupakan angka
                        if (preg_match("/\d+/", $str) == false) {
                            $name .= strtoupper($str) . " ";
                        }
                        // apabila kata dimulai dari angka
                        else if (preg_match("/\d+T?(AHUN|AHU|HN|H)?/i", $str)) {
                            $age = preg_replace("/[^0-9]/", "", $str);
                            $foundNumber = true;
                        }
                    }
                    // memastikan bahwa kata bukan kata tahun, thn, th, dan sejenisnya
                    else if (preg_match("/\b(tahun|tahu|thn|ta|th|tn|tun)\b/i", $str) == false) {
                        $city .= strtoupper($str) . " ";
                    }
                }

                $name = trim($name);
                $city = trim($city);

                $user->update([
                    'name' => $name,
                    'age' => $age,
                    'city' => $city,
                ]);

                return back()->with('success', 'Update data berhasil dilakukan');

            } else {
                return back()->with('error', 'Format Inputan Tidak Sesuai');
            }
        }
    }

    public function delete(Request $request) {
        $request->validate([
            'id' => ['required'],
        ]);

        $user = User::findOrFail($request->id);
        $user->delete();

        return back()->with('success', 'Data berhasil dihapus');
    }
}

