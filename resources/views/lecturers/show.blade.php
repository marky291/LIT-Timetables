@extends('layouts.app')

@section('content')

    <div class="max-w-6xl px-4 mx-auto py-14 sm:px-6 lg:px-8">
        <div class="text-center">
            <h2 class="text-3xl font-bold leading-9 tracking-tight text-gray-900 sm:text-4xl sm:leading-10">
                {{ $lecturer->name }}
            </h2>
        </div>
        {{-- <div class="mt-10">
            <h3 class="text-xl font-medium leading-6 text-gray-900">
                LIT Timetable Service
            </h3>
            <div class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-3">
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="px-4 py-5 text-center sm:p-6">
                        <dl>
                            <dt class="text-sm font-medium leading-5 text-gray-500 truncate">
                                Response Status
                            </dt>
                            <dd
                                class="inline-flex items-center px-4 py-2 mt-4 text-lg font-medium leading-5 text-green-800 capitalize bg-green-100 rounded-md">
                                {{ $course->request->response == 200 ? 'Online' : 'Offline' }}
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="px-4 py-5 text-center sm:p-6">
                        <dl>
                            <dt class="text-sm font-medium leading-5 text-gray-500 truncate">
                                Response Time
                            </dt>
                            <dd
                                class="inline-flex items-center px-4 py-2 mt-4 text-lg font-medium leading-5 text-gray-800 capitalize bg-gray-200 rounded-md">
                                {{ $course->request->time }} seconds
                            </dd>
                        </dl>
                    </div>
                </div>
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="px-4 py-5 text-center sm:p-6">
                        <dl>
                            <dt class="text-sm font-medium leading-5 text-gray-500 truncate">
                                Last Checked
                            </dt>
                            <dd
                                class="inline-flex items-center px-4 py-2 mt-4 text-lg font-medium leading-5 text-gray-800 bg-gray-200 rounded-md">
                                {{ $course->request->created_at->diffForHumans() }}
                            </dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div> --}}

        @livewire('schedules.today', ['schedules' => $schedules])

        @livewire('schedules.week', ['schedules' => $schedules])

        {{-- <div class="py-2 mt-6 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <div
                class="min-w-full overflow-hidden align-middle bg-white border-b border-gray-200 shadow inline-course sm:rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg font-medium leading-6 text-gray-900">
                        Event History
                    </h3>
                    <p class="max c-w-2xl mt-1 text-sm leading-5 text-gray-500">
                        Timetable events within the last 30 days.
                    </p>
                </div>
                <table class="min-w-full">
                    <thead>
                        <tr>
                            <th
                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase whitespace-no-wrap border-t border-b border-gray-200 bg-gray-50">
                                Timestamp
                            </th>
                            <th
                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase whitespace-no-wrap border-t border-b border-gray-200 bg-gray-50">
                                Event
                            </th>
                            <th
                                class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-t border-b border-gray-200 bg-gray-50">
                                Reason
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        <tr>
                            <td
                                class="w-1 px-6 py-3 text-sm font-medium leading-5 text-gray-900 whitespace-no-wrap border-b border-gray-200">
                                <div>Thu, Oct 29</div>
                                <div class="text-xs font-normal text-gray-500">15:11:02</div>
                            </td>
                            <td
                                class="w-1 px-6 py-3 text-sm leading-5 text-gray-500 whitespace-no-wrap border-b border-gray-200 m">
                                Tokyo
                            </td>
                            <td class="px-6 py-3 text-sm leading-5 text-gray-500 border-b border-gray-200">
                                <div>Connection not possible for host `http://timetable.lit.ie:8080/studentset.htm`.</div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-10">
            <h3 class="text-xl font-medium leading-6 text-gray-900">
                Last Months
            </h3>
            <div class="grid grid-cols-1 gap-5 mt-5 sm:grid-cols-1 lg:grid-cols-4">
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="px-4 py-5 sm:p-6 ">
                        <div class="mb-3"><span class="text-lg font-bold text-gray-800">August</span> <span
                                class="ml-1 text-lg font-normal text-gray-500">2020</span></div>
                        <div class="flex flex-wrap mb-3">
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Mo</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Tu</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">We</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Th</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Fr</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Sa</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Su</div>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="px-4 py-5 sm:p-6 ">
                        <div class="mb-3"><span class="text-lg font-bold text-gray-800">September</span> <span
                                class="ml-1 text-lg font-normal text-gray-500">2020</span></div>
                        <div class="flex flex-wrap mb-3">
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Mo</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Tu</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">We</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Th</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Fr</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Sa</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Su</div>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="px-4 py-5 sm:p-6 ">
                        <div class="mb-3"><span class="text-lg font-bold text-gray-800">October</span> <span
                                class="ml-1 text-lg font-normal text-gray-500">2020</span></div>
                        <div class="flex flex-wrap mb-3">
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Mo</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Tu</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">We</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Th</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Fr</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Sa</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Su</div>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-red-100 border-2 border-red-500 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-red-100 border-2 border-red-500 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-green-100 border-2 border-green-500 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-red-100 border-2 border-red-500 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-green-100 border-2 border-green-500 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-green-100 border-2 border-green-500 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="overflow-hidden bg-white rounded-lg shadow">
                    <div class="px-4 py-5 sm:p-6 ">
                        <div class="mb-3"><span class="text-lg font-bold text-gray-800">November</span> <span
                                class="ml-1 text-lg font-normal text-gray-500">2020</span></div>
                        <div class="flex flex-wrap mb-3">
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Mo</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Tu</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">We</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Th</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Fr</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Sa</div>
                            <div class="text-xs font-medium text-center text-gray-800" style="width: 14.28%;">Su</div>
                        </div>
                        <div class="flex flex-wrap">
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 rounded-full inline-course lg:h-4 lg:w-4"></span></div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-green-100 border-2 border-green-500 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-green-100 border-2 border-green-500 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-green-100 border-2 border-green-500 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-green-100 border-2 border-green-500 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                            <div class="mb-1.5 text-center" style="width: 14.28%;"><span
                                    class="w-6 h-6 bg-gray-100 border-2 border-gray-100 rounded-full inline-course lg:h-4 lg:w-4"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="items-center justify-center mt-6 md:flex">
            <div class="flex items-center">
                <div class="w-4 h-4 m-2 bg-green-100 border-2 border-green-500 rounded-full md:m-3"></div>
                <div class="text-sm text-gray-500">No Downtime</div>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 m-2 bg-yellow-100 border-2 border-yellow-500 rounded-full md:m-3"></div>
                <div class="text-sm text-gray-500">Downtime &lt; 15 min.</div>
            </div>
            <div class="flex items-center">
                <div class="w-4 h-4 m-2 bg-red-100 border-2 border-red-500 rounded-full md:m-3"></div>
                <div class="text-sm text-gray-500">Downtime &gt; 15 min.</div>
            </div>
        </div> --}}
        <div class="mt-8 text-xs leading-9 tracking-tight text-center text-gray-500">
            Want to make this your favorite place <a
                href="https://brainstorm.io?ref=statuspage" class="text-blue-600 hover:text-blue-500">Add us to your homescreen</a>
        </div>
    </div>
@endsection
