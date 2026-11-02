<?php
declare(strict_types=1);

final class ReportPeriod
{
    public static function resolve(string $from, string $to, ?string $earliest = null, ?DateTimeImmutable $today = null): array
    {
        $today = ($today ?? new DateTimeImmutable('today', new DateTimeZone('Asia/Amman')))->setTime(0, 0);
        $todayText = $today->format('Y-m-d');
        foreach ([$from, $to] as $value) {
            if ($value === '')
                continue;
            $date = DateTimeImmutable::createFromFormat('!Y-m-d', $value, $today->getTimezone());
            if (!$date || $date->format('Y-m-d') !== $value)
                throw new InvalidArgumentException('Please enter valid dates.');
            if ($value > $todayText)
                throw new InvalidArgumentException('Report dates cannot be in the future.');
        }
        if ($from === '' && $to === '') {
            $previousMonth = $today->modify('first day of last month');
            $from = $previousMonth->setDate((int) $previousMonth->format('Y'), (int) $previousMonth->format('m'), min((int) $today->format('d'), (int) $previousMonth->format('t')))->format('Y-m-d');
            $to = $todayText;
        } elseif ($to === '') {
            $to = $todayText;
        } elseif ($from === '') {
            $from = $earliest !== null && $earliest <= $to ? $earliest : $to;
        }
        if ($to < $from)
            throw new InvalidArgumentException('The end date must be after or equal to the start date.');
        return ['from' => $from, 'to' => $to];
    }
}
