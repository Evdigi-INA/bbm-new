{{-- Master data --}}
<div class="row">
    <div class="col-md-12" style="margin-bottom: 1em;">
        <h3>Master Data
            @error('permissions')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </h3>
    </div>

    {{-- Mata Uang --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <strong>Mata Uang</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'mata uang') && !Str::contains($permission->name, 'rate'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- rate matauang --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <strong>Rate Mata Uang</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'rate'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- bank --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <strong>Bank</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'bank'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- rekening --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <strong>Rekening</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'rekening'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>
</div>

<div class="row">
    {{-- supplier --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <strong>Supplier</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'supplier'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- area --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <strong>Area</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'area'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- pelanggan --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <strong>Pelanggan</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'pelanggan'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- salesman --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <strong>Salesman</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'salesman') && !Str::contains($permission->name, 'laporan'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>
</div>

<div class="row">
    {{-- gudang --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <strong>Gudang</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'gudang'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- satuan --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <strong>Satuan</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'satuan'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- kategori --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <strong>Kategori</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'kategori'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- barang --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <strong>Barang</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'barang') && !Str::contains($permission->name, 'laporan'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>
</div>

{{-- Inventory --}}
<div class="row justify-conter-center">
    <div class="col-md-12" style="margin-bottom: 1em;">
        <h3>Inventory</h3>
    </div>

    {{-- adjustment plus --}}
    <div class="col-md-4" style="margin-bottom: 1em;">
        <strong>Adjustment Plus</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'adjustment plus') && !Str::contains($permission->name, 'laporan'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- adjustment minus --}}
    <div class="col-md-4" style="margin-bottom: 1em;">
        <strong>Adjustment Minus</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'adjustment minus') && !Str::contains($permission->name, 'laporan'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- perakitan paket --}}
    <div class="col-md-4" style="margin-bottom: 1em;">
        <strong>Perakitan Paket</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'perakitan paket'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>
</div>

{{-- Pembelian --}}
<div class="row justify-conter-center">
    <div class="col-md-12" style="margin-bottom: 1em;">
        <h3>Pembelian</h3>
    </div>

    {{-- pesanan pembelian --}}
    <div class="col-md-4" style="margin-bottom: 1em;">
        <strong>Pesanan Pembelian</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'pesanan pembelian') && !Str::contains($permission->name, 'laporan'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- pembelian --}}
    <div class="col-md-4" style="margin-bottom: 1em;">
        <strong>Pembelian</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'pembelian') && !Str::contains($permission->name, 'retur') && !Str::contains($permission->name, 'pesanan') && !Str::contains($permission->name, 'laporan'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- retur --}}
    <div class="col-md-4" style="margin-bottom: 1em;">
        <strong>Retur Pembelian</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'retur pembelian') && !Str::contains($permission->name, 'laporan'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>
</div>

{{-- Penjualan & setting --}}
<div class="row justify-conter-center">
    {{-- Pesanan penjualan --}}
    <div class="col-md-9" style="margin-bottom: 1em;">
        <h3>Penjualan</h3>
        <div class="row">
            <div class="col-md-4" style="margin-bottom: 1em;">
                <strong>Pesanan Penjualan</strong>
                @foreach ($permissions as $permission)
                    @if (Str::contains($permission->name, 'pesanan penjualan') && !Str::contains($permission->name, 'laporan') && !Str::contains($permission->name, 'retur'))
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                {{ ucwords($permission->name) }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- penjualan --}}
            <div class="col-md-4" style="margin-bottom: 1em;">
                <strong>Penjualan</strong>
                @foreach ($permissions as $permission)
                    @if (Str::contains($permission->name, 'penjualan') && !Str::contains($permission->name, 'laporan') && !Str::contains($permission->name, 'retur') && !Str::contains($permission->name, 'pesanan penjualan'))
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                {{ ucwords($permission->name) }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>

            {{-- retur penjualan --}}
            <div class="col-md-4" style="margin-bottom: 1em;">
                <strong>Retur Penjualan</strong>
                @foreach ($permissions as $permission)
                    @if (Str::contains($permission->name, 'retur penjualan') && !Str::contains($permission->name, 'laporan'))
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                                    {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                                {{ ucwords($permission->name) }}
                            </label>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>

    {{-- toko --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <h3>Setting</h3>

        <strong>User dan Toko</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'toko') || Str::contains($permission->name, 'user'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>
</div>

{{-- keuagan --}}
<div class="row justify-conter-center">
    <div class="col-md-12" style="margin-bottom: 1em;">
        <h3>Keuangan</h3>
    </div>

    {{-- pelunasan hutang --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <strong>Pelunasan Hutang</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'pelunasan hutang') && !Str::contains($permission->name, 'laporan'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- pelunasan piutang --}}
    <div class="col-md-3" style="margin-bottom: 1em;">
        <strong>Pelunasan Piutang</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'pelunasan piutang') && !Str::contains($permission->name, 'laporan'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- cek/giro cair --}}
    <div class="col-md-2" style="margin-bottom: 1em;">
        <strong>Cek/Giro Cair</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'cek/giro cair'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- cek/giro tolak --}}
    <div class="col-md-2" style="margin-bottom: 1em;">
        <strong>Cek/Giro Tolak</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'cek/giro tolak'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    {{-- biaya --}}
    <div class="col-md-2" style="margin-bottom: 1em;">
        <strong>Biaya</strong>
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'biaya') && !Str::contains($permission->name, 'laporan'))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>
</div>

{{-- Laporan --}}
<div class="row justify-conter-center">
    <div class="col-md-12" style="margin-bottom: 1em;">
        <h3>Laporan</h3>
    </div>

    <div class="col-md-3">
        {{-- <strong>Laporan</strong> --}}
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'laporan') & ($loop->iteration <= 150))
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    <div class="col-md-3">
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'laporan') && $loop->iteration >= 151 && $loop->iteration <= 155)
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    <div class="col-md-3">
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'laporan') && $loop->iteration >= 156 && $loop->iteration <= 159)
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>

    <div class="col-md-3">
        @foreach ($permissions as $permission)
            @if (Str::contains($permission->name, 'laporan') && $loop->iteration >= 160)
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}"
                            {{ isset($user) && $user->permissions->contains($permission->id) ? 'checked' : '' }}>
                        {{ ucwords($permission->name) }}
                    </label>
                </div>
            @endif
        @endforeach
    </div>
</div>
