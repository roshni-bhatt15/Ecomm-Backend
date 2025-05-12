<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Kreait\Firebase\Contract\Auth as FirebaseAuth;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class FirebaseAuthController extends Controller
{
    protected $firebase;

    public function __construct(FirebaseAuth $firebase)
    {
        $this->firebase = $firebase;
    }

    public function login(Request $request)
    {
        $idToken = $request->input('idToken');

        try {
            $verifiedIdToken = $this->firebase->verifyIdToken($idToken);
            $uid = $verifiedIdToken->claims()->get('sub');

            $user = $this->firebase->getUser($uid);

            // Find or create user in your database
            $localUser = User::updateOrCreate(
                ['firebase_uid' => $uid],
                [
                    'name' => $user->displayName ?? 'No Name',
                    'email' => $user->email,
                    'firebase_uid' => $uid,
                ]
            );

            Auth::login($localUser);

            return response()->json([
                'message' => 'User logged in successfully',
                'user' => $localUser,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'error' => 'Invalid token: ' . $e->getMessage()
            ], 401);
        }
    }
}
