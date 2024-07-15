<div class="form-col">

    <div class="form-input">
        <label class="text-shadowed" for="title">Titre :</label>
        <input type="text" name="title" id="title"  value="{{ $event->title }}">
        @error('title')
        <p>
            {{ $message }}
        </p>
        @enderror
    </div>

    <div class="form-input">
        <label class="text-shadowed" for="description">Entête :</label>
        <input type="text" name="description" id="description" value="{{ $event->description }}">
        @error('description')
        <p>
            {{ $message }}
        </p>
        @enderror
    </div>

    <div class="form-input">
        <label for="start_date" class="text-shadowed">
            Date de début du GN :
        </label>
        <input type="date" name="start_date" id="start_date" value="{{ date('Y-m-d', strtotime($event->start_date)) }}" required>
        @error('start_date')
        <p>
            {{ $message }}
        </p>
        @enderror
    </div>

</div>
<div class="form-col">

    <div class="form-input">
        <label class="text-shadowed" for="end_date">Date de fin :</label>
        <input type="date" name="end_date" id="end_date" value="{{ $event->end_date ? date('Y-m-d', strtotime($event->end_date)) : null }}" >
        @error('end_date')
        <p>
            {{ $message }}
        </p>
        @enderror
    </div>

    <div class="form-input">
        <label class="text-shadowed" for="location_id">Lieu :</label>
        <select name="location_id" id="location_id" >
            @foreach($locations as $location)
            <option value="{{ $location->id }}" @if($location->id === $event->location_id) selected @endif>{{ $location->title }}</option>
            @endforeach
        </select>
    </div>

    <label class="text-shadowed" for="is_cancelled">Annuler :</label>
    <div class="form-check">
        <input type="checkbox" name="is_cancelled" id="is_cancelled" @if($event->is_cancelled) checked @endif>
        <p class="text-green italic">
            Si cette case est cochée, l'événement sera considéré comme annulé et sera caché de l'index des GN.
        </p>
    </div>


</div>
