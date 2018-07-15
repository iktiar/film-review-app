<?php

namespace App\Repository\Transformers;


class FilmTransformer extends Transformer {

    public function transform($film){

        return [
            'id' => $film->id,
            'name' => $film->title,
            'slug' => $film->slug,
            'description' => $film->description,
            'release_date' => $film->release_date,
            'rating' => $film->rating,
            'ticket_price' => $film->ticket_price,
            'country' => $film->country,
            'photo' => $film->photo,
        ];
    }

}