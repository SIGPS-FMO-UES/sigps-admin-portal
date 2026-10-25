COO-E02 / COO-HU-04
Reasignar tutor	Cambiar tutor asignado conservando al tutor anterior en el historial de asignaciones.	

✅ COMPLETADO	

Se conserva el registro histórico completo del tutor previo en la tabla de auditorías (`reasignacion_tutor`) con los IDs y nombres de ambos tutores.


COO-E03 / COO-HU-10
Enviar documento aprobado a UPS	Al contar con aprobación de tutor y coordinador, trasladar el expediente a Proyección Social.	

✅ COMPLETADO	

Se valida rígidamente en el controlador que el Coordinador no pueda emitir aval académico sin que el documento cuente previamente con la aprobación del Docente Tutor (`aprobado_tutor`).


COO-E04 / COO-HU-11
Historial de revisiones	Modelo de auditoría, trazabilidad de aprobaciones, rechazos, observaciones, responsable, fecha y timeline.	

✅ COMPLETADO	

Implementada la tabla y modelo de auditoría (`auditorias`); las observaciones y dictámenes nunca se sobreescriben, se preserva todo el historial inmutable con usuario responsable, fecha/hora, metadatos y timeline visual con filtros cronológicos avanzados. Acceso exclusivo para el Administrador del sistema.