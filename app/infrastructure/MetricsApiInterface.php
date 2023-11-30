<?php

namespace app\infrastructure;

interface MetricsApiInterface
{
    public function getIntraStudyMetricsByLifespans($data);
    public function getIntraStudyMetricsByGraph($data);
    
}