<?php

namespace Modules\Auth\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Modules\Auth\Http\Requests\RegisterRequest;
use Modules\Auth\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AuthController extends Controller
{
    /**
     * Logs user in generatin the login token
     */
    public function login(LoginRequest $request): JsonResponse
    {
      $user = User::where('email', $request->email)->first();
    
      if (! $user || ! Hash::check($request->password, $user->password)) {
         return response()->json([
           'message' => 'The provided credentials are incorrect.'
         ], Response::HTTP_UNPROCESSABLE_ENTITY);

      }

      return response()->json([
             'data' => [
             'attributes'=> [
                 'id' => $user->id,
                 'name' => $user->name,
                 'email' => $user->email
              ],
             'token' => $user->createToken($request->email)->plainTextToken
           ],
          ], Response::HTTP_OK);
    }

    /**
     * Create new user.
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $user = User::create([
            'name'=> $request->name,
            'email'=> $request->email,
            'password'=> Hash::make($request->password)
        ]);

        if( $user )
        {
            return response()->json($user, Response::HTTP_OK);
        }
        else{
            return response()->json($user, Response::HTTP_KO);
        }
        
    }

    /**
     * Updates user data
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function update(Request $request): JsonResponse
    {
        $user = Auth::user();
        
        $user->update($request->all());

        $user->save();

        return response()->json($user->toArray(), Response::HTTP_CREATED);
    }

    public function logged(Request $request, User $user): JsonResponse
    {
        $user = Auth::user();

        return response()->json($user->toArray(), Response::HTTP_CREATED);
    }

     /**
     * Remove the given user
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        Gate::authorize('destroy', $user);

        return $user->delete() ? response()->json("OK", Response::HTTP_CREATED) : response()->json("KO", Response::HTTP_CREATED);

    }
}
