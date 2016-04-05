/*
 * SonarQube Runner - API
 * Copyright (C) 2011-2016 SonarSource SA
 * mailto:contact AT sonarsource DOT com
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software Foundation,
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
package org.sonar.runner.impl;

import org.sonar.runner.batch.IsolatedLauncher;
import org.sonar.runner.batch.IssueListener;
import org.sonar.runner.batch.LogOutput;
import org.sonar.runner.cache.Logger;

import javax.annotation.Nullable;

import java.io.File;
import java.io.FileOutputStream;
import java.io.OutputStream;
import java.util.List;
import java.util.Properties;

public class SimulatedLauncher implements IsolatedLauncher {
  private final String version;
  private final Logger logger;
  private Properties globalProperties;

  SimulatedLauncher(String version, Logger logger) {
    this.version = version;
    this.logger = logger;
  }

  @Override
  public void start(Properties properties, LogOutput logOutput, boolean preferCache) {
    globalProperties = properties;
  }

  @Override
  public void stop() {
    globalProperties = null;
  }

  @Override
  public void execute(Properties properties) {
    dumpProperties(globalProperties, properties);
  }

  @Override
  public void execute(Properties properties, IssueListener listener) {
    dumpProperties(globalProperties, properties);
  }

  private void dumpProperties(@Nullable Properties global, Properties analysis) {
    // for old versions, analysis will have global properties merged in it
    String filePath;
    String filePathGlobal = null;
    if (global != null) {
      filePath = global.getProperty(InternalProperties.RUNNER_DUMP_TO_FILE);
      filePathGlobal = filePath + ".global";
    } else {
      filePath = analysis.getProperty(InternalProperties.RUNNER_DUMP_TO_FILE);
    }

    if (filePath == null) {
      throw new IllegalStateException("No file to dump properties");
    }

    if (global != null) {
      File dumpFileGlobal = new File(filePathGlobal);
      writeProperties(dumpFileGlobal, global, "global properties");
    }

    File dumpFile = new File(filePath);
    writeProperties(dumpFile, analysis, "analysis properties");
    logger.info("Simulation mode. Configuration written to " + dumpFile.getAbsolutePath());
  }

  private static void writeProperties(File outputFile, Properties p, String comment) {
    try (OutputStream output = new FileOutputStream(outputFile)) {
      p.store(output, "Generated by sonar-runner - " + comment);
    } catch (Exception e) {
      throw new IllegalStateException("Fail to export sonar-runner properties", e);
    }
  }

  @Override
  public void syncProject(String projectKey) {
    // no op
  }

  @Override
  public void executeOldVersion(Properties properties, List<Object> extensions) {
    dumpProperties(null, properties);
  }

  @Override
  public String getVersion() {
    return version;
  }

}