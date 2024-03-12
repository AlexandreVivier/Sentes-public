<article>
    <form action="{{ route('admin.events.update', $event->id) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <h2 class="text-green">Informations obligatoires :</h2>

            <div class="form-wrapper">

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
                        <input type="date" name="end_date" id="end_date"  value="{{ date('Y-m-d', strtotime($event->end_date)) }}">
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
            </div>

            <h2 class="text-green">Informations optionnelles :</h2>

            <div class="form-wrapper">
                <div class="form-col">

                    <div class="form-input">
                        <label class="text-shadowed" for="price">Prix :</label>
                        <input type="number" name="price" id="price"  value="{{ $event->price }}" >
                    </div>

                    <div class="form-input">
                        <label class="text-shadowed" for="max_attendees">Nombre de joueuses :</label>
                        <input type="number" name="max_attendees" id="max_attendees"  value="{{ $event->max_attendees }}">
                        @error('max_attendees')
                        <p>
                            {{ $message }}
                        </p>
                        @enderror
                    </div>

                    <div class="form-input">
                        <label class="text-shadowed" for="file_path">Courrier d'invitation :</label>
                        <input type="file" name="file_path" id="file_path" >
                        @error('file_path')
                        <p>
                            {{ $message }}
                        </p>
                        @enderror
                        @if ($event->file_path)
                        <p class="text-green">Fichier actuel :</p>
                        <a href="{{ asset('storage/' . $event->file_path) }}" class="text-green" target="_blank">Voir dans une autre page.</a>
                        @endif
                    </div>

                    <div class="form-input">
                        <label class="text-shadowed" for="tickets_link">Lien de la billetterie :</label>
                        <input type="text" name="tickets_link" id="tickets_link"  value="{{ $event->tickets_link }}">
                        @error('tickets_link')
                        <p>
                            {{ $message }}
                        </p>
                        @enderror
                        @if ($event->tickets_link)
                        <p class="text-green">Lien actuel :</p>
                        <a href="{{ $event->tickets_link }}" class="text-green" target="_blank">{{ $event->tickets_link}}</a>
                        @endif
                    </div>

                    <div class="form-input">
                        <label class="text-shadowed" for="server_link">Lien du serveur Discord :</label>
                        <input type="text" name="server_link" id="server_link"  value="{{ $event->server_link }}">
                        @error('server_link')
                        <p>
                            {{ $message }}
                        </p>
                        @enderror
                        @if ($event->server_link)
                        <p class="text-green">Lien actuel :</p>
                        <a href="{{ $event->server_link }}" class="text-green" target="_blank">{{ $event->server_link}}</a>
                        @endif
                    </div>


                </div>
                <div class="form-col">

                    <div class="form-input">
                        <label class="text-shadowed" for="image_path">Changer l'image :</label>
                        <input type="file" name="image_path" id="image_path" accept="image/png, image/jpeg" >
                        @error('image_path')
                        <p>
                            {{ $message }}
                        </p>
                        @enderror
                        <p class="text-green">Image actuelle :</p>
                        <div class="miniature-edit">
                            @if($event->image_path)
                                <img src="{{ asset('storage/' . $event->image_path) }}" alt="{{ $event->title }}" class="border-green-lg"/>
                            @else
                                <img src="https://4.bp.blogspot.com/-Fn6vUAcfjfc/XKX8XrbIbdI/AAAAAAAAEAY/FCkvO7D3VxoAdp-DCzoKc2TDh_rWc8LEgCLcBGAs/w1200-h630-p-k-no-nu/45463605214_203aba5749_c.jpg" alt="{{ $event->title }}" class="border-green-lg">
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="show-button-container">

            <div class="form-input">
                <a href="{{ route('admin.events.show', $event->id) }}" class="light-button special-elite-regular w-100">
                    Annuler
                </a>
            </div>

            <div class="form-input">
                <button type="submit" class="green-button special-elite-regular w-100">
                    Enregistrer
                </button>
            </div>

        </div>
    </form>
</article>
