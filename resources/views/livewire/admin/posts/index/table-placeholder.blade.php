<div class="flex flex-col gap-8">
    <div>
        <div class="relative animate-pulse">
            <div class="p-3">
                <div class="w-full bg-gray-100 rounded-lg">&nbsp;</div>
            </div>
            <table class="w-full table-fixed divide-y divide-gray-300 text-gray-800">
                <tbody class="divide-y divide-gray-200 bg-white text-gray-700 w-full">
                    @foreach (range(0, 5) as $i)
                        <tr>
                            <td class="whitespace-nowrap p-3 text-sm">
                                <div class="w-full bg-gray-200 rounded-lg">&nbsp;</div>
                            </td>
                            <td class="whitespace-nowrap p-3 text-sm">
                                <div class="w-full bg-gray-200 rounded-lg">&nbsp;</div>
                            </td>
                            <td class="whitespace-nowrap p-3 text-sm">
                                <div class="w-full bg-gray-200 rounded-lg">&nbsp;</div>
                            </td>
                            <td class="whitespace-nowrap p-3 text-sm">
                                <div class="w-full bg-gray-200 rounded-lg">&nbsp;</div>
                            </td>
                            <td class="whitespace-nowrap p-3 text-sm">
                                <div class="w-full bg-gray-200 rounded-lg">&nbsp;</div>
                            </td>
                            <td class="whitespace-nowrap p-3 text-sm">
                                <div class="w-full bg-gray-200 rounded-lg">&nbsp;</div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>