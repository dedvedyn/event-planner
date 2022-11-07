<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Throwable;

class EventController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function getEvents(Request $request)
    {
        $datesFromTo = $request->get('datesFromTo');
        $dateFrom = strtotime($datesFromTo[0]);
        $dateTo = strtotime($datesFromTo[1]);
        $events = DB::table('events')
            ->whereBetween('time', [$dateFrom, $dateTo])
            ->get();

        return response()->json($events);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function setEvent(Request $request)
    {
        try {
            $validatedData = $this->inputDataValidation($request);

            if (isset($validatedData['errors'])) {
                return response()->json([
                    'success' => false,
                    'errors' => $validatedData['errors']
                ]);
            }

            DB::table('events')->insert($validatedData);

            return response()->json([
                'success' => true
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'error' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function editEvent(Request $request)
    {
        try {
            $validatedData = $this->inputDataValidation($request);

            if (isset($validatedData['errors'])) {
                return response()->json([
                    'success' => false,
                    'errors' => $validatedData['errors']
                ]);
            }

            DB::table('events')
                ->updateOrInsert(
                    ['id' => $request->get('id')],
                    $validatedData
                );

            return response()->json([
                'success' => true
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'error' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteEvent(Request $request)
    {
        try {
            $deleted = DB::table('events')
                ->where('id', '=', $request->get('id'))
                ->delete();

            return response()->json([
                'success' => true,
                'deleted' => $deleted
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'error' => $exception->getMessage()
            ]);
        }
    }

    /**
     * @param Request $request
     * @return array
     * @throws ValidationException
     */
    protected function inputDataValidation(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|min:5|max:255',
                'description' => 'required|min:5|max:255',
                'type' => 'required',
                'location' => 'required|min:5|max:255',
                'time' => 'required',
            ]
        );

        if ($validator->fails()) {
            return ['errors' => $validator->errors()->getMessages()];
        }

        $validatedData = $validator->validate();
        $validatedData['time'] = strtotime($validatedData['time']);

        return $validatedData;
    }
}
