<div>
    <label for="posyandu_id" class="block font-medium text-sm text-gray-700">Posyandu</label>
    <select id="posyandu_id" name="posyandu_id" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">
        <option value="">-- Pilih Posyandu --</option>
        @foreach($posyandus as $posyandu)
            <option value="{{ $posyandu->posyandu_id }}"
                {{ (isset($jadwalPosyandu->posyandu_id) && $jadwalPosyandu->posyandu_id == $posyandu->posyandu_id) ? 'selected' : '' }}>
                {{ $posyandu->nama }}
            </option>
        @endforeach
    </select>
    {!! $errors->first('posyandu_id', '<p class="text-red-500 text-sm mt-1">:message</p>') !!}
</div>

<div>
    <label for="tanggal" class="block font-medium text-sm text-gray-700">Tanggal</label>
    <input type="date" id="tanggal" name="tanggal" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" 
        value="{{ isset($jadwalPosyandu->tanggal) ? $jadwalPosyandu->tanggal : '' }}">
    {!! $errors->first('tanggal', '<p class="text-red-500 text-sm mt-1">:message</p>') !!}
</div>

<div>
    <label for="tema" class="block font-medium text-sm text-gray-700">Tema</label>
    <input type="text" id="tema" name="tema" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" 
        value="{{ isset($jadwalPosyandu->tema) ? $jadwalPosyandu->tema : '' }}">
    {!! $errors->first('tema', '<p class="text-red-500 text-sm mt-1">:message</p>') !!}
</div>

<div>
    <label for="keterangan" class="block font-medium text-sm text-gray-700">Keterangan</label>
    <textarea id="keterangan" name="keterangan" rows="4" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full">{{ isset($jadwalPosyandu->keterangan) ? $jadwalPosyandu->keterangan : '' }}</textarea>
    {!! $errors->first('keterangan', '<p class="text-red-500 text-sm mt-1">:message</p>') !!}
</div>

<div class="flex items-center gap-4 mt-4">
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>