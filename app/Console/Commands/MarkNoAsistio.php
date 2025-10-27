<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reserva;
use Carbon\Carbon;

class MarkNoAsistio extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mark:no-asistio';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Marcar reservas pendientes cuya fecha y hora ya pasaron como no_asistio';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $this->info('Comprobando reservas vencidas a las: ' . $now->toDateTimeString());

        $count = 0;

        Reserva::where('estado', 'pendiente')
            ->chunkById(200, function($reservas) use (&$count, $now) {
                foreach ($reservas as $reserva) {
                    try {
                        // $reserva->fecha puede ser instancia Carbon (está en $dates), si no, lo parseamos
                        $fecha = $reserva->fecha;
                        if (! $fecha instanceof Carbon) {
                            $fecha = Carbon::parse($reserva->fecha);
                        }

                        // Construir datetime usando fecha (Y-m-d) y hora (string)
                        $horaString = trim((string) $reserva->hora);
                        if ($horaString === '') {
                            continue; // sin hora
                        }

                        $fechaHora = Carbon::parse($fecha->format('Y-m-d') . ' ' . $horaString);

                        if ($fechaHora->lt($now)) {
                            $reserva->estado = 'no_asistio';
                            $reserva->save();
                            $count++;
                        }
                    } catch (\Exception $e) {
                        // ignorar reservas mal formadas y continuar
                        continue;
                    }
                }
            });

        $this->info("Reservas marcadas como no_asistio: {$count}");

        return 0;
    }
}
