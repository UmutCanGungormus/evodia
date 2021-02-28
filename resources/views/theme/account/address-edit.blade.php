    <form onsubmit="return false;" method="post" id="addressEdit" enctype="multipart/form-data">
        <div class="form-group row mb-3">
            <div class="col-3 align-items-center">
                <label for="address_title">Adres Başlığı :</label>
            </div>
            <div class="col-9">
                <input type="text" name="title" value="{{ $data->title }}" id="address_title"
                    placeholder="Adres Başlığı" class="form-control rounded-0 addAddressTitle">
            </div>
        </div>

        <div class="form-group row mb-3">
            <div class="col-3 align-items-center">
                <label for="tc">Telefon :</label>
            </div>
            <div class="col-9">
                <input type="text" name="phone" id="phone" value="{{ $data->phone }}" placeholder="Phone"
                    class="form-control rounded-0 ">
            </div>
        </div>
        <div class="form-group row mb-3">
            <div class="col-3 align-items-center">
                <label for="addresss_city">İl :</label>
            </div>
            <div class="col-9">
                <select name="city_id" id="address_city"
                    onchange="changeCity($(this),'.nsdistrict','.nsneighborhood','.nsquarter')"
                    class="city nscity w-100 form-control rounded-0 addAddressCity">
                    @foreach ($cities as $city)
                        <option {{ $city->id == $data->city_id ?? 'selected' }} value="{{ $city->id }}">
                            {{ $city->il_adi }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row mb-3">
            <div class="col-3 align-items-center">
                <label for="address_district">İlçe :</label>
            </div>
            <div class="col-9">
                <select name="district_id" id="address_district"
                    onchange="changeDistrict($(this),'.nsneighborhood','.nsquarter')"
                    class="district nsdistrict w-100 form-control rounded-0 addAddressDistrict">
                    @foreach ($districts as $district)
                        <option {{ $district->id == $data->district_id ?? 'selected' }} value="{{ $district->id }}">
                            {{ $district->ilce_adi }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row mb-3">
            <div class="col-3 align-items-center">
                <label for="address_neighborhood">Semt :</label>
            </div>
            <div class="col-9">
                <select name="neighborhood_id" id="address_neighborhood"
                    onchange="changeNeighborhood($(this),'.nsquarter')"
                    class="neighborhood nsneighborhood w-100 form-control rounded-0 addAddressNeighborhood">
                    @foreach ($neighborhoods as $neighborhood)
                        <option {{ $neighborhood->id == $data->neighborhood_id ?? 'selected' }}
                            value="{{ $neighborhood->id }}">{{ $neighborhood->semt_adi }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row mb-3">
            <div class="col-3 align-items-center">
                <label for="address_quarter">Mahalle :</label>
            </div>
            <div class="col-9">
                <select name="quarter_id" id="address_quarter"
                    class="quarter nsquarter form-control w-100 rounded-0 addAddressQuarter">
                    @foreach ($quarters as $quarter)
                        <option {{ $quarter->id == $data->quarter_id ?? 'selected' }} value="{{ $quarter->id }}">
                            {{ $quarter->mahalle_adi }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-group row mb-3">
            <div class="col-3 align-items-center">
                <label for="address_address">Sokak Bilgisi :</label>
            </div>
            <div class="col-9">
                <textarea name="address" id="address_address" placeholder="Sokak Bilgisi"
                    class="form-control rounded-0 addAddressAddress">{{ $data->address }}</textarea>
            </div>
        </div>
        <div class="form-group mb-3">
            <button data-id="{{ $data->id }}" role="button"
                class="btn btn-dark AddressEdit float-right rounded-0">Adres Bilgisini
                Düzenle</button>
        </div>
    </form>
