<div>
    <label for="nama" class="block font-medium text-sm text-gray-700">{{ 'Nama' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="nama" name="nama" type="text" value="{{ isset($posyandu->nama) ? $posyandu->nama : ''}}" >
    {!! $errors->first('nama', '<p>:message</p>') !!}
</div>
<div>
    <label for="alamat" class="block font-medium text-sm text-gray-700">{{ 'Alamat' }}</label>
    <textarea id="alamat" name="alamat" type="textarea" rows="5" class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" >{{ isset($posyandu->alamat) ? $posyandu->alamat : ''}}</textarea>

    {!! $errors->first('alamat', '<p>:message</p>') !!}
</div>
<div>
    <label for="rt" class="block font-medium text-sm text-gray-700">{{ 'Rt' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="rt" name="rt" type="text" value="{{ isset($posyandu->rt) ? $posyandu->rt : ''}}" >
    {!! $errors->first('rt', '<p>:message</p>') !!}
</div>
<div>
    <label for="rw" class="block font-medium text-sm text-gray-700">{{ 'Rw' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="rw" name="rw" type="text" value="{{ isset($posyandu->rw) ? $posyandu->rw : ''}}" >
    {!! $errors->first('rw', '<p>:message</p>') !!}
</div>
<div>
    <label for="kontak" class="block font-medium text-sm text-gray-700">{{ 'Kontak' }}</label>
    <input class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm mt-1 block w-full" id="kontak" name="kontak" type="text" value="{{ isset($posyandu->kontak) ? $posyandu->kontak : ''}}" >
    {!! $errors->first('kontak', '<p>:message</p>') !!}
</div>


<div class="flex items-center gap-4">
    <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 focus:bg-gray-700 active:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
        {{ $formMode === 'edit' ? 'Update' : 'Create' }}
    </button>
</div>
