<?php

namespace Tests\Feature;

use Tests\TestCase;

class HomePageTest extends TestCase
{
    public function test_home_page_renders_navbar_and_whatsapp_registration_links(): void
    {
        $pesantren = config('pesantren');
        $pesan = "Assalamu'alaikum, saya ingin mendapatkan informasi mengenai pendaftaran santri baru ".$pesantren['nama'].' Tahun Ajaran '.$pesantren['tahun'].'.';
        $tautan = 'https://wa.me/'.$pesantren['wa_panitia'].'?text='.rawurlencode($pesan);

        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee($tautan, false);
        $response->assertSee('Daftar PSB Online');
        $response->assertSee('Bimbingan Belajar Komputer');
        $response->assertDontSee('sm:absolute sm:-bottom-8', false);
    }

    public function test_home_page_uses_ux_typography_form_and_scrollspy_markers(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('text-balance', false);
        $response->assertSee('xl:text-[2.5rem]', false);
        $response->assertSee('leading-[1.15]', false);
        $response->assertSee('text-[15px]', false);
        $response->assertSee('flex-wrap', false);
        $response->assertSee('pb-20 pt-10', false);
        $response->assertDontSee('xl:text-[2.75rem]', false);
        $response->assertSee('Mengenal Dasar Komputer.', false);
        $response->assertDontSee('line-clamp', false);
        $response->assertSee('data-nav-link', false);
        $response->assertSee('inputmode="tel"', false);
        $response->assertSee('autocomplete="name"', false);
        $response->assertSee('autocomplete="tel"', false);
        $response->assertSee('data-error-for="nama"', false);
        $response->assertDontSee('py-20', false);
        $response->assertDontSee('text-white/60', false);
        $response->assertDontSee('text-[11px]', false);
    }

    public function test_leadership_cards_use_neutral_ring_with_hover_and_focus_states(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertSee('ring-2 ring-pine-100', false);
        $response->assertSee('hover:ring-pine-700', false);
        $response->assertSee('hover:ring-pine-500', false);
        $response->assertSee('focus-within:ring-pine-700', false);
        $response->assertSee('focus-within:ring-pine-500', false);
        $response->assertSee('focus-within:shadow-xl', false);
        $response->assertSee('duration-300', false);
    }
}
