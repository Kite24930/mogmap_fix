@props(['disabled' => false])

<select {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm']) !!}>
    <option value="-1" class="hidden" selected>ジャンルを選択してください</option>
    <option value="0">新規ジャンル</option>
    {{ $slot }}
</select>
